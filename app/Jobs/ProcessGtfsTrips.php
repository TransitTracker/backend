<?php

namespace App\Jobs;

use App\Agency;
use App\Route;
use App\Service;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;

class ProcessGtfsTrips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $file;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $file
     */
    public function __construct(Agency $agency, string $file)
    {
        $this->agency = $agency;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump("[Trips-StartRead]");
        $tripsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        var_dump("[Trips-Foreach]");

        $count = count($tripsReader);
        $position = 0;
        foreach ($tripsReader->getRecords() as $trip) {
            // Find the route and service matching this trip
            $route = Route::where([['agency_id', $this->agency->id], ['route_id', $trip['route_id']]])->first();
            $service = Service::where([['agency_id', $this->agency->id], ['service_id', $trip['service_id']]])->first();

            $position += 1;

            // If there is no service, don't add it
            if ($service) {
                var_dump("[Trips-Continue {$position}/{$count}]");
                // Prepare a new array to update or create the trip model
                $newTrip = [];

                // Fill each required attribute
                $newTrip['trip_id'] = $trip['trip_id'];
                $newTrip['trip_headsign'] = $trip['trip_headsign'];

                // Fill optional trip attribute
                if (array_key_exists('trip_short_name', $trip)) {
                    $newTrip['trip_short_name'] = $trip['trip_short_name'];
                }

                // Fill optional route attributes
                $newTrip['route_color'] = $route->color;
                $newTrip['route_text_color'] = $route->text_color;
                $newTrip['route_short_name'] = $route->short_name;
                $newTrip['route_long_name'] = $route->long_name;

                // Fill optional service attribute
                $newTrip['service_id'] = $service->id;

                // Create or update the trip model
                Trip::updateOrCreate(['trip_id' => $trip['trip_id'], 'agency_id' => $this->agency->id], $newTrip);
            } else {
                var_dump("[Trips-Skip {$position}/{$count}]");
            }
        }
        $tripsReader = null;
        var_dump("[Trips-End]");
    }
}
