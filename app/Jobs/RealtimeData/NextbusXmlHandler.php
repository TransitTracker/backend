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

class NextbusXmlHandler implements ShouldQueue
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
        Vehicle::where([
            ['active', true],
            ['agency_id', $this->agency->id],
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
             * Find a (fake) trip for this route
             */
            $trip = Trip::where([['agency_id', '=', $this->agency->id], ['trip_id', '=', $vehicle['routeTag']]])
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
            if ($vehicle['lat']) {
                $newVehicle['lat'] = round((float) $vehicle['lat'], 5);
            }

            // Longitude
            if ($vehicle['lon']) {
                $newVehicle['lon'] = round((float) $vehicle['lon'], 5);
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

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($xml->vehicle),
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
