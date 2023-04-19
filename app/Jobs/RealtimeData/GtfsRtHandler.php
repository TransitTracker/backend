<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleExpiredGtfs;
use App\Models\Agency;
use App\Models\Stat;
use App\Models\Trip;
use App\Models\Vehicle;
use Exception;
use FelixINX\TransitRealtime\FeedMessage;
use Google\Protobuf\Internal\GPBDecodeException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use MatanYadaev\EloquentSpatial\Objects\Point;

class GtfsRtHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  string  $dataFile
     */
    public function __construct(private Agency $agency, private $dataFile, private int $time)
    {
    }

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
            ['is_active', true],
            ['agency_id', $this->agency->id],
        ])->select(['id', 'is_active', 'active'])->get();
        $activeArray = [];

        $data = Storage::get($this->dataFile);

        // Convert protobuf to PHP object
        try {
            $feed = new FeedMessage();
            $feed->mergeFromString($data);
            $count = count($feed->getEntity());
        } catch (GPBDecodeException $e) {
            Log::error("Error while decoding GTFS-RT feed from {$this->agency->slug}: {$e->getMessage()}");
            Storage::delete($this->dataFile);

            return;
        }

        $vehiclesWithoutTrip = 0;

        // Go trough each vehicle
        foreach ($feed->getEntity() as $entity) {
            /*
             * Check if entity has vehiclePosition or if is not valid
             */
            $vehicle = $entity->getVehicle();
            if (! $vehicle || ! $vehicle->getTrip() || ! $vehicle->getPosition()) {
                continue;
            }

            /*
             * Check if trip is in database
             */
            $trip = Trip::where([['agency_id', '=', $this->agency->id], ['gtfs_trip_id', '=', $vehicle->getTrip()->getTripId()]])
                ->select('id')
                ->first();

            if (! $trip) {
                $vehiclesWithoutTrip += 1;
            }

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [
                'active' => 1,
                'is_active' => 1,
                'gtfs_trip' => $this->processField($vehicle->getTrip()->getTripId()), // old
                'gtfs_trip_id' => $this->processField($vehicle->getTrip()->getTripId()),
                'route' => $this->processField($vehicle->getTrip()->getRouteId() ?? $trip?->route_short_name), // old
                'gtfs_route_id' => $this->processField($vehicle->getTrip()->getRouteId(), 'route', $trip?->route_short_name),
                'start' => $this->processField($vehicle->getTrip()->getStartTime()), // old
                'start_time' => $this->processField($vehicle->getTrip()->getStartTime()),
                'relationship' => $this->processField($vehicle->getTrip()->getScheduleRelationship()), // old
                'schedule_relationship' => $this->processField($vehicle->getTrip()->getScheduleRelationship()),
                'label' => $this->processField($vehicle->getVehicle()->getLabel(), 'label'),
                'plate' => $this->processField($vehicle->getVehicle()->getLicensePlate()),  // old
                'license_plate' => $this->processField($vehicle->getVehicle()->getLicensePlate()),
                'lat' => $this->processField(round($vehicle->getPosition()->getLatitude(), 5)), //old
                'lon' => $this->processField(round($vehicle->getPosition()->getLongitude(), 5)), //old
                'position' => $this->processField(['lat' => $vehicle->getPosition()->getLatitude(), 'lon' => $vehicle->getPosition()->getLongitude()], 'position'), //old
                'bearing' => $this->processField($vehicle->getPosition()->getBearing()),
                'odometer' => $this->processField(round($vehicle->getPosition()->getOdometer() / 1000, 0)),
                'speed' => $this->processField(round($vehicle->getPosition()->getSpeed() * 3.6, 0)),
                'stop_sequence' => $this->processField($vehicle->getCurrentStopSequence()), // old
                'current_stop_sequence' => $this->processField($vehicle->getCurrentStopSequence()),
                'status' => $this->processField($vehicle->getCurrentStatus()), // old
                'current_status' => $this->processField($vehicle->getCurrentStatus()),
                'timestamp' => $this->processField($vehicle->getTimestamp() ?? $this->time),
                'congestion' => $this->processField($vehicle->getCongestionLevel()), // old
                'congestion_level' => $this->processField($vehicle->getCongestionLevel()),
                'occupancy' => $this->processField($vehicle->getOccupancyStatus()), // old
                'occupancy_status' => $this->processField($vehicle->getOccupancyStatus()),
                'gtfs_stop_id' => $this->processField($vehicle->getStopId()),
                'trip_id' => $this->processField($trip?->id),
            ];

            /*
             * Create or update the vehicle model
             */
            try {
                $vehicle = Vehicle::updateOrCreate(['vehicle_id' => $vehicle->getVehicle()->getId(), 'agency_id' => $this->agency->id], $newVehicle);

                array_push($activeArray, $vehicle->id);
            } catch (Exception $e) {
                // London Transit Comission oftens have vehicles with invalid coordinates, ignore these
                if ($this->agency->slug === 'ltc' && str($e->getMessage())->contains("1264 Out of range value for column 'lon'")) {
                    return;
                }

                Log::warning('Vehicle in the refresh failed', [
                    'agency' => $this->agency->slug,
                    'exception' => $e->getMessage(),
                ]);
            }
        }

        // Update active information
        if ($inactiveArray->except($activeArray)->count() > 0) {
            $inactiveArray->except($activeArray)->toQuery()->update(['active' => false, 'is_active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = $feed->getHeader()->getTimestamp();
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
    }

    private function processField($value, string $transformer = null)
    {
        if (! filled($value)) {
            return null;
        }

        if ($transformer === 'label' && in_array($this->agency->slug, ['go', 'up', 'la', 'vr', 'lr', 'lasso', 'sju', 'so', 'hsl', 'pi', 'rous', 'sv', 'tm', 'crc'])) {
            return null;
        }

        if ($transformer === 'position' && filled($value['lat']) && filled($value['lat'])) {
            return new Point($value['lat'], $value['lon']);
        }

        return $value;
    }
}
