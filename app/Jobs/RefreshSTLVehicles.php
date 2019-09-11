<?php

namespace App\Jobs;

use App\Agency;
use App\Events\VehiclesUpdated;
use App\Stat;
use App\Vehicle;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\ResponseCache\Facades\ResponseCache;

class RefreshSTLVehicles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $time;

    /**
     * Create a new job instance.
     *
     * @param int $time
     * @return void
     */
    public function __construct(int $time)
    {
        $this->time = $time;
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
            // Check if vehicle is up to date
            // Todo: fix
//            if ($vehicle['secsSinceReport'] > 180) {
//                break;
//            }

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

        // Send a new event to alert browser that vehicles have been refresh
        event(new VehiclesUpdated($agency));
        ResponseCache::clear(['vehicles']);

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($xml->vehicle),
            'agency' => $agency->slug,
            'time' => $this->time
        ];
        $stat->save();
    }
}
