<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleExpiredGtfs;
use App\Models\Agency;
use App\Models\Gtfs\Trip;
use App\Models\Stat;
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
        ])->select(['id', 'is_active'])->get();
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

            // TODO: For the gtfs_route_id, the Vehicle model should retreive it through the Trip if this field is not filled

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [
                'is_active' => true,
                'gtfs_trip_id' => $this->processField($vehicle->getTrip()->getTripId()),
                'gtfs_route_id' => $this->processField($vehicle->getTrip()->getRouteId()),
                'start_time' => $this->processField($vehicle->getTrip()->getStartTime()),
                'schedule_relationship' => $this->processField($vehicle->getTrip()->getScheduleRelationship()),
                'label' => $this->processField($vehicle->getVehicle()->getLabel(), 'label'),
                'license_plate' => $this->processField($vehicle->getVehicle()->getLicensePlate()),
                'position' => $this->processField(['lat' => $vehicle->getPosition()->getLatitude(), 'lon' => $vehicle->getPosition()->getLongitude()], 'position'),
                'bearing' => $this->processField($vehicle->getPosition()->getBearing()),
                'odometer' => $this->processField(round($vehicle->getPosition()->getOdometer() / 1000, 0)),
                'speed' => $this->processField(round($vehicle->getPosition()->getSpeed() * 3.6, 0)),
                'current_stop_sequence' => $this->processField($vehicle->getCurrentStopSequence()),
                'current_status' => $this->processField($vehicle->getCurrentStatus()),
                'timestamp' => $this->processField($vehicle->getTimestamp() ?? $this->time),
                'congestion_level' => $this->processField($vehicle->getCongestionLevel()),
                'occupancy_status' => $this->processField($vehicle->getOccupancyStatus()),
                'gtfs_stop_id' => $this->processField($vehicle->getStopId()),
            ];

            /*
             * Create or update the vehicle model
             */
            try {
                $vehicle = Vehicle::updateOrCreate(['agency_id' => $this->agency->id, 'vehicle_id' => $vehicle->getVehicle()->getId()], $newVehicle);

                $activeArray[] = $vehicle->id;
            } catch (Exception $e) {
                // London Transit Commission often have vehicles with invalid coordinates, ignore these
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
            $inactiveArray->except($activeArray)->toQuery()->update(['is_active' => false]);
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
            return new Point(round($value['lat'], 5), round($value['lon'], 5));
        }

        return $value;
    }
}
