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

class RefreshSTMVehicles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stmApiKey;

    /**
     * Create a new job instance.
     *
     * @param string $stmApiKey
     * @return void
     */
    public function __construct(string $stmApiKey)
    {
        $this->stmApiKey = $stmApiKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find agency id
        $agencyId = Agency::where('slug', 'stm')->firstOrFail()->id;

        // Put all previously active vehicles inactive
        Vehicle::where([['active', '=', '1'], ['agency_id', '=', $agencyId]])->update(['active' => false]);

        // Initialize client and call api
        $client = new Client();
        $result = $client->post('https://api.stm.info/pub/od/gtfs-rt/ic/v1/vehiclePositions', ['headers' => ['apikey' => $this->stmApiKey]]);

        // Convert protobuff to PHP object
        $feed = new FeedMessage();
        $feed->parse($result->getBody()->getContents());

        // Go trough
        foreach ($feed->getEntityList() as $entity) {
            // Check if the trip exist
            $trip = Trip::where([['agency_id', '=', $agencyId], ['trip_id', '=', $entity->vehicle->trip->getTripId()]])
                ->select('id')
                ->first();

            // If trip doesn't exist, create an empty one
            if (!isset($trip)) {
                $trip = new stdClass();
                $trip->id = null;
            }

            // Create or update the vehicle
            Vehicle::updateOrCreate(
                ['vehicle' => $entity->getId(), 'agency_id' => $agencyId],
                [
                    'active' => 1,
                    'agency_id' => $agencyId,
                    'lat' => round($entity->vehicle->position->getLatitude(), 5),
                    'lon' => round($entity->vehicle->position->getLongitude(), 5),
                    'route' => $entity->vehicle->trip->getRouteId(),
                    'status' => $entity->vehicle->getCurrentStatus(),
                    'stop_sequence' => $entity->vehicle->getCurrentStopSequence(),
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
        Mail::to(env('MAIL_TO'))->send(new JobFailed($exception, 'STM'));
    }
}
