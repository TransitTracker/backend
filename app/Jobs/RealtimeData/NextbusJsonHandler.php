<?php

namespace App\Jobs\RealtimeData;

use App\Events\VehiclesUpdated;
use App\Models\Agency;
use App\Models\Stat;
use App\Models\Trip;
use App\Models\Vehicle;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NextbusJsonHandler implements ShouldQueue
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

        // Convert JSON to PHP object
        $json = json_decode($data);

        $timestamp = floor($json->lastTime->time / 1000);

        // Return early if there is no vehicles
        if (! property_exists($json, 'vehicle')) {
            return;
        }

        // Go trough each vehicle
        foreach ($json->vehicle as $vehicle) {
            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [];
            $newVehicle['active'] = 1;

            /*
             * Find a (fake) trip for this route
             */
            $trip = Trip::where([['agency_id', '=', $this->agency->id], ['trip_id', '=', $vehicle->routeTag]])
                ->select('id')
                ->first();

            /*
             * Try each attribute
             */

            // Trip
            if ($trip) {
                $newVehicle['trip_id'] = $trip->id;
            }

            // Latitude
            if ($lat = $vehicle->lat) {
                $newVehicle['lat'] = round((float) $lat, 5);
            }

            // Longitude
            if ($lon = $vehicle->lon) {
                $newVehicle['lon'] = round((float) $lon, 5);
            }

            // Route
            if ($routeTag = $vehicle->routeTag) {
                $newVehicle['route'] = $routeTag;
            }

            // Bearing
            if ($heading = $vehicle->heading) {
                $newVehicle['bearing'] = $heading;
            }

            // Speed
            if ($speedKmHr = $vehicle->speedKmHr) {
                $newVehicle['speed'] = $speedKmHr;
            }

            // Timestamp
            if ($secsSinceReport = $vehicle->secsSinceReport) {
                $newVehicle['timestamp'] = strval($timestamp - $secsSinceReport);
            }

            /*
             * Check if vehicle is recent, then create or update the vehicle model
             */
            if ($vehicle->secsSinceReport < 180) {
                $vehicle = Vehicle::updateOrCreate(['vehicle' => $vehicle->id, 'agency_id' => $this->agency->id], $newVehicle);

                array_push($activeArray, $vehicle->id);
            }
        }

        // Update active information
        if ($inactiveArray->except($activeArray)->count() > 0) {
            $inactiveArray->except($activeArray)->toQuery()->update(['active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = (int) $timestamp;
        $this->agency->save();

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($json->vehicle),
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
