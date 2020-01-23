<?php

namespace App\Jobs;

use App\Stat;
use App\Trip;
use Exception;
use App\Agency;
use App\Vehicle;
use Illuminate\Bus\Queueable;
use App\Events\VehiclesUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class RefreshForNextbus implements ShouldQueue
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
            ['active' => false]
        );

        $data = Storage::get($this->dataFile);

        // Convert XML to PHP object
        $xml = simplexml_load_string($data);

        // Go trough each vehicle
        foreach ($xml->vehicle as $vehicle) {
            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [];
            $newVehicle['active'] = 1;

            /*
             * Try each GTFS RT attribute
             */

            // Latitude
            if ($vehicle['lat']) {
                $newVehicle['lat'] = round($vehicle['lat'], 5);
            }

            // Longitude
            if ($vehicle['lon']) {
                $newVehicle['lon'] = round($vehicle['lon'], 5);
            }

            // Route
            if ($vehicle['routeTag']) {
                $newVehicle['route'] = $vehicle['routeTag'];
            }

            // Bearing
            if ($vehicle['heading']) {
                $newVehicle['bearing'] = $vehicle['heading'];
            }

            // Speed
            if ($vehicle['speedKmHr']) {
                $newVehicle['speed'] = $vehicle['speedKmHr'];
            }

            /*
             * Check if vehicle is recent, then create or update the vehicle model
             */
            if ($vehicle['secsSinceReport'] < 180) {
                Vehicle::updateOrCreate(['vehicle' => $vehicle['id'], 'agency_id' => $this->agency->id], $newVehicle);
            }
        }

        // Replace timestamp
        $this->agency->timestamp = (int) floor($xml->lastTime['time'] / 1000);
        $this->agency->save();

        // Send a new event to alert browser that vehicles have been refresh
        ResponseCache::clear();
        event(new VehiclesUpdated($this->agency));

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object)[
            'count' => count($xml->vehicle),
            'agency' => $this->agency->slug,
            'time' => $this->time
        ];
        $stat->save();

        print_r('[LOG] RefreshForNextbus:' . $this->agency->slug . ' at ' . $this->time . ' with ' . count($xml->vehicle) . ' vehicles\n');

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
