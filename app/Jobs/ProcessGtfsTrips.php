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
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class ProcessGtfsTrips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $file;
    private int $offset;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $file
     * @param int $offset
     */
    public function __construct(Agency $agency, string $file, int $offset = 0)
    {
        $this->agency = $agency;
        $this->file = $file;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tripsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        $tripsStatement = (new Statement())
            ->offset($this->offset)
            ->limit(50000);
        $tripsRecords = $tripsStatement->process($tripsReader);

        // Check if there is a fallback trip
        $fallbackService = DB::table('services')
            ->where('agency_id', $this->agency->id)
            ->where('service_id', "FALLBACK-{$this->agency->slug}")
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();

        foreach ($tripsRecords as $trip) {
            // Find the route and service matching this trip
            $route = Route::firstWhere([['agency_id', $this->agency->id], ['route_id', $trip['route_id']]]);
            if ($fallbackService) {
                $service = $fallbackService;
            } else {
                $service = Service::firstWhere([['agency_id', $this->agency->id], ['service_id', $trip['service_id']]]);
            }

            // If there is no service, don't add it
            if ($service) {
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

                // Fill optional shape attribute
                if (array_key_exists('shape_id', $trip)) {
                    $newTrip['shape'] = $trip['shape_id'];
                }

                // Create or update the trip model
                Trip::updateOrCreate(['trip_id' => $trip['trip_id'], 'agency_id' => $this->agency->id], $newTrip);
            }
        }
        $tripsReader = null;
    }
}
