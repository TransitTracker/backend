<?php

namespace App\Jobs;

use stdClass;
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
        // Find agency id
        $agencyId = Agency::where('slug', 'stl')->firstOrFail()->id;

        // Put all previously active vehicles inactive
        Vehicle::where([['active', '=', '1'], ['agency_id', '=', $agencyId]])->update(['active' => false]);

        // Initialize client and call api
        $client = new Client();
        $result = $client->get('http://webservices.nextbus.com/service/publicXMLFeed?command=vehicleLocations&a=stl&t=0');

        // Convert xml to PHP object
        $xml = simplexml_load_string($result->getBody());

        // Go trough
        foreach ($xml->vehicle as $vehicle) {

            // Create or update the vehicle
            Vehicle::updateOrCreate(
                ['vehicle' => $vehicle['id'], 'agency_id' => $agencyId],
                [
                    'active' => 1,
                    'agency_id' => $agencyId,
                    'route' => $vehicle['routeTag'],
                    'lat' => round($vehicle['lat'], 5),
                    'lon' => round($vehicle['lon'], 5),
                    'bearing' => $vehicle['heading'],
                    'speed' => $vehicle['speedKmHr']
                ]
            );
        }
    }
}
