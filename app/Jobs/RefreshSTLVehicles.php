<?php

namespace App\Jobs;

use App\Agency;
use App\Vehicle;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefreshSTLVehicles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find agency
        $agency = Agency::where('slug', 'stl')->firstOrFail();

        // Put all previously active vehicles inactive
        Vehicle::where([['active', '=', '1'], ['agency_id', '=', $agency->id]])->update(['active' => false]);

        // Initialize client and call api
        $client = new Client();
        $result = $client->get('http://webservices.nextbus.com/service/publicXMLFeed?command=vehicleLocations&a=stl&t=0');

        // Convert xml to PHP object
        $xml = simplexml_load_string($result->getBody());

        // Update timestamp
        $agency->timestamp = (int) floor($xml->lastTime['time'] / 1000);
        $agency->save();

        // Go trough
        foreach ($xml->vehicle as $vehicle) {
            // Todo: check timestamp
            // Create or update the vehicle
            Vehicle::updateOrCreate(
                ['vehicle' => $vehicle['id'], 'agency_id' => $agency->id],
                [
                    'active' => 1,
                    'agency_id' => $agency->id,
                    'route' => $vehicle['routeTag'],
                    'lat' => round((float) $vehicle['lat'], 5),
                    'lon' => round((float) $vehicle['lon'], 5),
                    'bearing' => $vehicle['heading'],
                    'speed' => $vehicle['speedKmHr']
                ]
            );
        }
    }
}
