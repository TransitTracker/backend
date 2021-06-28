<?php

namespace App\Jobs\RealtimeData;

use App\Events\VehiclesUpdated;
use App\Models\Agency;
use App\Models\Stat;
use App\Models\Trip;
use App\Models\Vehicle;
use Exception;
use FelixINX\TransitRealtime\FeedMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GtfsRtHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $dataFile;
    private int $time;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $dataFile
     * @param int $time
     */
    public function __construct(Agency $agency, $dataFile, $time)
    {
        $this->agency = $agency;
        $this->dataFile = $dataFile;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        // Put all previously active vehicle as inactive
        $inactiveArray = Vehicle::where([
            ['active', true],
            ['agency_id', $this->agency->id],
        ])->select(['id', 'active'])->get();
        $activeArray = [];

        $data = Storage::get($this->dataFile);

        // Convert protobuf to PHP object
        $feed = new FeedMessage();
        $feed->mergeFromString($data);

        // Go trough each vehicle
        foreach ($feed->getEntity() as $entity) {
            /*
             * Check if entity has vehiclePosition or if is not valid
             */
            $vehicle = $entity->getVehicle();
            if (! $vehicle || ! $vehicle->getTrip()) {
                continue;
            }

            /*
             * Check if trip is in database
             */
            $trip = Trip::where([['agency_id', '=', $this->agency->id], ['trip_id', '=', $vehicle->getTrip()->getTripId()]])
                ->select('id')
                ->first();

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [];
            $newVehicle['active'] = 1;

            /*
             * Try each GTFS RT attribute
             */

            // trip->trip_id
            if ($gtfs_trip = $vehicle->getTrip()->getTripId()) {
                $newVehicle['gtfs_trip'] = $gtfs_trip;
            } else {
                $newVehicle['gtfs_trip'] = null;
            }

            // trip->route_id
            if ($route = $vehicle->getTrip()->getRouteId()) {
                $newVehicle['route'] = $route;
            } else {
                $newVehicle['route'] = null;
            }

            // trip->start_time
            if ($start = $vehicle->getTrip()->getStartTime()) {
                $newVehicle['start'] = $start;
            } else {
                $newVehicle['start'] = null;
            }

            // trip->schedule_relationship
            if ($relationship = $vehicle->getTrip()->getScheduleRelationship()) {
                $newVehicle['relationship'] = $relationship;
            } else {
                $newVehicle['relationship'] = null;
            }

            // vehicle->label
            // Don't use the label feed for GO Transit
            if ($vehicle->getVehicle()->getLabel() && (! in_array($this->agency->slug, ['go', 'la', 'vr', 'lr', 'lasso', 'sju', 'so', 'hsl', 'pi', 'rous', 'sv', 'tm', 'crc']))) {
                $newVehicle['label'] = $vehicle->getVehicle()->getLabel();
            } else {
                $newVehicle['label'] = null;
            }

            // vehicle->plate
            if ($plate = $vehicle->getVehicle()->getLicensePlate()) {
                $newVehicle['plate'] = $plate;
            } else {
                $newVehicle['plate'] = null;
            }

            // position->latitude
            if ($lat = $vehicle->getPosition()->getLatitude()) {
                $newVehicle['lat'] = round($lat, 5);
            } else {
                $newVehicle['lat'] = null;
            }

            // position->longitude
            if ($lon = $vehicle->getPosition()->getLongitude()) {
                $newVehicle['lon'] = round($lon, 5);
            } else {
                $newVehicle['lon'] = null;
            }

            // position->bearing
            if ($bearing = $vehicle->getPosition()->getBearing()) {
                $newVehicle['bearing'] = $bearing;
            } else {
                $newVehicle['bearing'] = null;
            }

            // position->odometer
            if ($odometer = $vehicle->getPosition()->getOdometer()) {
                $newVehicle['odometer'] = round($odometer / 1000, 0);
            } else {
                $newVehicle['odometer'] = null;
            }

            // position->speed
            if ($speed = $vehicle->getPosition()->getSpeed()) {
                $newVehicle['speed'] = round($speed * 3.6, 0);
            } else {
                $newVehicle['speed'] = null;
            }

            // current_stop_sequence
            if ($stop_sequence = $vehicle->getCurrentStopSequence()) {
                $newVehicle['stop_sequence'] = $stop_sequence;
            } else {
                $newVehicle['stop_sequence'] = null;
            }
            // current_status
            if ($status = $vehicle->getCurrentStatus()) {
                $newVehicle['status'] = $status;
            } else {
                $newVehicle['status'] = null;
            }

            // timestamp
            if ($timestamp = $vehicle->getTimestamp()) {
                $newVehicle['timestamp'] = $timestamp;
            } else {
                $newVehicle['timestamp'] = null;
            }

            // congestion_level
            if ($congestion = $vehicle->getCongestionLevel()) {
                $newVehicle['congestion'] = $congestion;
            } else {
                $newVehicle['congestion'] = null;
            }

            // occupancy_status
            if ($occupancy = $vehicle->getOccupancyStatus()) {
                $newVehicle['occupancy'] = $occupancy;
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
                $vehicle = Vehicle::updateOrCreate(['vehicle' => $vehicle->getVehicle()->getId(), 'agency_id' => $this->agency->id], $newVehicle);

                array_push($activeArray, $vehicle->id);
            } catch (Exception $e) {
                Log::error('Vehicle in the refresh failed', [
                    'agency' => $this->agency->slug,
                    'exception' => $e->getMessage(),
                ]);
            }
        }

        // Update active information
        if ($inactiveArray->except($activeArray)->count() > 0) {
            $inactiveArray->except($activeArray)->toQuery()->update(['active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = $feed->getHeader()->getTimestamp();
        $this->agency->save();

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($feed->getEntity()),
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
