<?php

namespace App\Jobs;

use App\Trip;
use App\Route;
use App\Agency;
use App\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGtfsTrip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;
    private $trip;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param $trip
     */
    public function __construct(Agency $agency, $trip)
    {
        $this->agency = $agency;
        $this->trip = $trip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find the route and service matching this trip
        $route = Route::where([['agency_id', $this->agency->id], ['route_id', $this->trip['route_id']]])->first();
        $service = Service::where([['agency_id', $this->agency->id], ['service_id', $this->trip['service_id']]])->first();

        // Prepare a new array to update or create the trip model
        $newTrip = [];

        // Fill each required attribute
        $newTrip['trip_id'] = $this->trip['trip_id'];
        $newTrip['trip_headsign'] = $this->trip['trip_headsign'];

        // Fill optional trip attribute
        if (array_key_exists('trip_short_name', $this->trip)) {
            $newTrip['trip_short_name'] = $this->trip['trip_short_name'];
        }

        // Fill optional route attributes
        $newTrip['route_color'] = $route->color;
        $newTrip['route_text_color'] = $route->text_color;
        $newTrip['route_short_name'] = $route->short_name;
        $newTrip['route_long_name'] = $route->long_name;

        // Fill optional service attribute
        $newTrip['service_id'] = $service->id;

        // Create or update the trip model
        Trip::updateOrCreate(['trip_id' => $this->trip['trip_id'], 'agency_id' => $this->agency->id], $newTrip);
    }
}
