<?php

namespace App\Jobs;

use Spatie\ResponseCache\Facades\ResponseCache;
use stdClass;
use App\Trip;
use App\Stat;
use Exception;
use App\Agency;
use App\Vehicle;
use GuzzleHttp\Client;
use App\Mail\JobFailed;
use Illuminate\Bus\Queueable;
use App\Events\VehiclesUpdated;
use transit_realtime\FeedMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefreshExoVehicles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exoApiKey;
    protected $exoSectorKey;
    protected $time;

    /**
     * Create a new job instance.
     *
     * @param string $exoApiKey
     * @param string $exoSectorKey
     * @param int $time
     * @return void
     */
    public function __construct(string $exoApiKey, string $exoSectorKey, int $time)
    {
        $this->exoApiKey = $exoApiKey;
        $this->exoSectorKey = $exoSectorKey;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find agency id
        $agency = Agency::where('gtfs_id', $this->exoSectorKey)->firstOrFail();

        // Put all previously active vehicles inactive
        Vehicle::where([['active', '=', '1'], ['agency_id', '=', $agency->id]])->update(['active' => false]);

        // Initialize client and call api
        $client = new Client();
        $result = $client->get('http://opendata.rtm.quebec:2539/ServiceGTFSR/VehiclePosition.pb?token=' . $this->exoApiKey . '&agency=' . $this->exoSectorKey);

        // Convert protobuff to PHP object
        $feed = new FeedMessage();
        $feed->parse($result->getBody()->getContents());

        // Replace timestamp
        $agency->timestamp = $feed->getHeader()->getTimestamp();
        $agency->save();
        
        // Go trough
        foreach ($feed->getEntityList() as $entity) {
            // Check if the trip exist
            $trip = Trip::where([['agency_id', $agency->id], ['trip_id', $entity->vehicle->trip->getTripId()]])
                ->select('id')
                ->first();

            // If trip doesn't exist, create an empty one
            if (!isset($trip)) {
                $trip = new stdClass();
                $trip->id = null;
            }

            // Create or update the vehicle
            Vehicle::updateOrCreate(
                ['vehicle' => $entity->getId(), 'agency_id' => $agency->id],
                [
                    'active' => 1,
                    'agency_id' => $agency->id,
                    'lat' => round($entity->vehicle->position->getLatitude(), 5),
                    'lon' => round($entity->vehicle->position->getLongitude(), 5),
                    'route' => $entity->vehicle->trip->getRouteId(),
                    'bearing' => $entity->vehicle->position->getBearing(),
                    'speed' => round($entity->vehicle->position->getSpeed()*3.6, 0),
                    'gtfs_trip' => $entity->vehicle->trip->getTripId(),
                    'trip_id' => $trip->id
                ]
            );
        }

        // Send a new event to alert browser that vehicles have been refresh
        if ($agency->is_active) {
            event(new VehiclesUpdated($agency));
            ResponseCache::clear(['vehicles']);
        }

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($feed->getEntityList()),
            'agency' => $agency->slug,
            'time' => $this->time
        ];
        $stat->save();
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Mail::to(env('MAIL_TO'))->send(new JobFailed($exception, $this->exoSectorKey));
    }
}
