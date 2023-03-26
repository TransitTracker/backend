<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleExpiredGtfs;
use App\Models\Agency;
use App\Models\Stat;
use App\Models\Trip;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JavascriptGtfsRtHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  string  $dataFile
     * @param  int  $time
     */
    public function __construct(private Agency $agency, private $dataFile, private $time)
    {
    }

    private array $activeArray = [];

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws Exception
     */
    public function handle()
    {
        // Put all previously active vehicle as inactive
        $inactiveArray = Vehicle::where([
            ['active', true],
            ['agency_id', $this->agency->id],
        ])->select(['id', 'active'])->get();

        $filePath = Storage::path($this->dataFile);
        $printGtfsRt = config('transittracker.print_gtfs_rt_bin');

        // Convert protobuf to PHP object
        try {
            $feed = shell_exec("cat '{$filePath}' | {$printGtfsRt} -s");
            $collection = collect(json_decode($feed));
            $count = $collection->count();
        } catch (Exception $e) {
            Log::error("Error while decoding GTFS-RT feed from {$this->agency->slug}: {$e->getMessage()}");
            Storage::delete($this->dataFile);

            return;
        }

        $vehiclesWithoutTrip = 0;

        // Go trough each vehicle
        $collection->each(function ($entity) use ($vehiclesWithoutTrip) {
            /*
             * Check if entity has vehiclePosition or if is not valid
             */
            if (! property_exists($entity, 'vehicle') || ! property_exists($entity->vehicle, 'trip') || ! property_exists($entity->vehicle, 'position')) {
                return;
            }
            $vehicle = $entity->vehicle;

            /*
             * Check if trip is in database
             */
            $trip = Trip::where([['agency_id', $this->agency->id], ['trip_id', $vehicle->trip->trip_id]])
                ->select(['id', 'route_short_name'])
                ->first();

            if (! $trip) {
                $vehiclesWithoutTrip += 1;
            }

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [];
            $newVehicle['active'] = 1;

            /*
             * Try each GTFS RT attribute
             */

            // trip->trip_id
            $newVehicle['gtfs_trip'] = $vehicle->trip->trip_id;

            // trip->route_id
            if (property_exists($vehicle->trip, 'route_id')) {
                $newVehicle['route'] = $vehicle->trip->route_id;
            } elseif ($trip) {
                $newVehicle['route'] = $trip->route_short_name;
            } else {
                $newVehicle['route'] = 'null';
            }

            // trip->start_time
            if (property_exists($vehicle->trip, 'start_time')) {
                $newVehicle['start'] = $vehicle->trip->start_time;
            } else {
                $newVehicle['start'] = null;
            }

            // trip->schedule_relationship
            if (property_exists($vehicle->trip, 'schedule_relationship')) {
                $newVehicle['relationship'] = $vehicle->trip->schedule_relationship;
            } else {
                $newVehicle['relationship'] = null;
            }

            // vehicle->label
            // Don't use the label feed for GO Transit or exo
            if (property_exists($vehicle->vehicle, 'label') && (! in_array($this->agency->slug, ['go', 'la', 'vr', 'lr', 'lasso', 'sju', 'so', 'hsl', 'pi', 'rous', 'sv', 'tm', 'crc']))) {
                $newVehicle['label'] = $vehicle->vehicle->label;
            } else {
                $newVehicle['label'] = null;
            }

            // vehicle->plate
            if (property_exists($vehicle->vehicle, 'license_plate')) {
                $newVehicle['plate'] = $vehicle->vehicle->license_plate;
            } else {
                $newVehicle['plate'] = null;
            }

            // position->latitude
            if (property_exists($vehicle->position, 'latitude')) {
                $newVehicle['lat'] = round($vehicle->position->latitude, 5);
            } else {
                $newVehicle['lat'] = null;
            }

            // position->longitude
            if (property_exists($vehicle->position, 'longitude')) {
                $newVehicle['lon'] = round($vehicle->position->longitude, 5);
            } else {
                $newVehicle['lon'] = null;
            }

            // position->bearing
            if (property_exists($vehicle->position, 'bearing')) {
                $newVehicle['bearing'] = $vehicle->position->bearing;
            } else {
                $newVehicle['bearing'] = null;
            }

            // position->odometer
            if (property_exists($vehicle->position, 'odometer')) {
                $newVehicle['odometer'] = round($vehicle->position->odometer / 1000, 0);
            } else {
                $newVehicle['odometer'] = null;
            }

            // position->speed
            if (property_exists($vehicle->position, 'speed')) {
                $newVehicle['speed'] = round($vehicle->position->speed * 3.6, 0);
            } else {
                $newVehicle['speed'] = null;
            }

            // current_stop_sequence
            if (property_exists($vehicle, 'current_stop_sequence')) {
                $newVehicle['stop_sequence'] = $vehicle->current_stop_sequence;
            } else {
                $newVehicle['stop_sequence'] = null;
            }
            // current_status
            if (property_exists($vehicle, 'current_status')) {
                $newVehicle['status'] = $vehicle->current_status;
            } else {
                $newVehicle['status'] = null;
            }

            // timestamp
            if (property_exists($vehicle, 'timestamp')) {
                $newVehicle['timestamp'] = $vehicle->timestamp->low;

                if (now()->diffInMinutes(new Carbon($vehicle->timestamp->low)) > 3) {
                    return;
                }
            } else {
                $newVehicle['timestamp'] = null;
            }

            // congestion_level
            if (property_exists($vehicle, 'congestion_level')) {
                $newVehicle['congestion'] = $vehicle->congestion_level;
            } else {
                $newVehicle['congestion'] = null;
            }

            // occupancy_status
            if (property_exists($vehicle, 'occupancy_status')) {
                $newVehicle['occupancy'] = $vehicle->occupancy_status;
            } else {
                $newVehicle['occupancy'] = null;
            }

            // Trip ID (from model)
            if ($trip) {
                $newVehicle['trip_id'] = $trip->id;
            } else {
                $newVehicle['trip_id'] = null;
            }

            /*
             * Create or update the vehicle model
             */
            try {
                $vehicleModel = Vehicle::updateOrCreate(['vehicle' => $vehicle->vehicle->id, 'agency_id' => $this->agency->id], $newVehicle);

                $this->activeArray[] = $vehicleModel->id;
            } catch (Exception $e) {
                Log::error('Vehicle in the refresh failed', [
                    'agency' => $this->agency->slug,
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);
            }
        });

        // Update active information
        if ($inactiveArray->except($this->activeArray)->count() > 0) {
            $inactiveArray->except($this->activeArray)->toQuery()->update(['active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = $this->time;
        $this->agency->save();

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => $count,
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Launch a notification if more than half of the vehicles don't have corresponding trip
        if ($count > 0 && ($vehiclesWithoutTrip / $count) > 0.5) {
            $action = new HandleExpiredGtfs($this->agency);
            $action->execute();
        }

        // Delete the file
        Storage::delete($this->dataFile);
    }

    public function fail()
    {
        Storage::delete($this->dataFile);
    }
}
