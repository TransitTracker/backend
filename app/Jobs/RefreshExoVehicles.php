<?php

namespace App\Jobs;

use stdClass;
use App\Trip;
use Exception;
use App\Agency;
use App\Vehicle;
use GuzzleHttp\Client;
use App\Mail\JobFailed;
use Illuminate\Bus\Queueable;
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

    /**
     * Create a new job instance.
     *
     * @param string $exoApiKey
     * @param string $exoSectorKey
     * @return void
     */
    public function __construct(string $exoApiKey, string $exoSectorKey)
    {
        $this->exoApiKey = $exoApiKey;
        $this->exoSectorKey = $exoSectorKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find agency id
        $agencyId = Agency::where('slug', $this->exoSectorKey)->firstOrFail()->id;

        // Put all previously active vehicles inactive
        Vehicle::where([['active', '=', '1'], ['agency_id', '=', $agencyId]])->update(['active' => false]);

        // Initialize client and call api
        $client = new Client();
        $result = $client->get('http://opendata.rtm.quebec:2539/ServiceGTFSR/VehiclePosition.pb?token=' . $this->exoApiKey . '&agency=' . $this->exoSectorKey);

        // Convert protobuff to PHP object
        $feed = new FeedMessage();
        $feed->parse($result->getBody()->getContents());

        // Go trough
        foreach ($feed->getEntityList() as $entity) {
            // Check if the trip exist
            $trip = Trip::where([['agency_id', $agencyId], ['trip_id', $entity->vehicle->trip->getTripId()]])
                ->select('id')
                ->first();

            // Create or update the vehicle
            Vehicle::updateOrCreate(
                ['vehicle' => $entity->getId(), 'agency_id' => $agencyId],
                [
                    'active' => 1,
                    'agency_id' => $agencyId,
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
