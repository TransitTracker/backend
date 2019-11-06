<?php

namespace App\Jobs;

use App\Events\VehiclesUpdated;
use App\Stat;
use App\Trip;
use Exception;
use App\Agency;
use App\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use FelixINX\TransitRealtime\FeedMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class RefreshForGTFS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;
    private $dataFile;
    private $time;

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
        Vehicle::where([
            ['active', true],
            ['agency_id', $this->agency->id]
        ])->update(
            ['active'=> false]
        );

        $data = Storage::get($this->dataFile);

        // Convert protobuff to PHP object
        $feed = new FeedMessage();
        $feed->mergeFromString($data);

        // Replace timestamp
        $this->agency->timestamp = $feed->getHeader()->getTimestamp();

        // Go trough each vehicle
        foreach ($feed->getEntity() as $entity) {
            try {
                /*
                 * Check if trip is in database
                 */
                $trip = Trip::where([['agency_id', '=', $this->agency->id], ['trip_id', '=', $entity->getVehicle()->getTrip()->getTripId()]])
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

                // Latitude
                if ($entity->getVehicle()->getPosition()->getLatitude()) {
                    $newVehicle['lat'] = round($entity->getVehicle()->getPosition()->getLongitude(), 5);
                }

                // Longitude
                if ($entity->getVehicle()->getPosition()->getLongitude()) {
                    $newVehicle['lon'] = round($entity->getVehicle()->getPosition()->getLongitude(), 5);
                }

                // Route
                if ($entity->getVehicle()->getTrip()->getRouteId()) {
                    $newVehicle['route'] = $entity->getVehicle()->getTrip()->getRouteId();
                }

                // Status
                if ($entity->getVehicle()->getCurrentStatus()) {
                    $newVehicle['status'] = $entity->getVehicle()->getCurrentStatus();
                }
                // Stop sequence
                if ($entity->getVehicle()->getCurrentStopSequence()) {
                    $newVehicle['stop_sequence'] = $entity->getVehicle()->getCurrentStopSequence();
                }

                // Start time
                if ($entity->getVehicle()->getTrip()->getStartTime()) {
                    $newVehicle['start'] = $entity->getVehicle()->getTrip()->getStartTime();
                }

                // Bearing
                if ($entity->getVehicle()->getPosition()->getBearing()) {
                    $newVehicle['bearing'] = $entity->getVehicle()->getPosition()->getBearing();
                }

                // Speed
                if ($entity->getVehicle()->getPosition()->getSpeed()) {
                    $newVehicle['speed'] = round($entity->getVehicle()->getPosition()->getSpeed() * 3.6, 0);
                }

                // Trip ID (from GTFS-RT)
                if ($entity->getVehicle()->getTrip()->getTripId()) {
                    $newVehicle['gtfs_trip'] = $entity->getVehicle()->getTrip()->getTripId();
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
                Vehicle::updateOrCreate(['vehicle' => $entity->getId(), 'agency_id' => $this->agency->id], $newVehicle);
            } catch (Exception $e) {
                $this->reportException($e);
            }
        }

        // Send a new event to alert browser that vehicles have been refresh
//        ResponseCache::clear(['vehicles']);
        event(new VehiclesUpdated($this->agency));

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($feed->getEntity()),
            'agency' => $this->agency->slug,
            'time' => $this->time
        ];
        $stat->save();

        print_r($this->agency->slug . ' at ' . $this->time . ' with ' . count($feed->getEntity()) . ' vehicles');

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
