<?php

namespace App\Jobs;

use App\Trip;
use App\Route;
use App\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PopulateTrip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trip;
    protected $agency;
    protected $expiration;

    /**
     * Create a new job instance.
     *
     * @param array $trip
     * @param Agency $agency
     * @param string $expiration
     * @return void
     */
    public function __construct(array $trip, Agency $agency, string $expiration)
    {
        $this->trip = $trip;
        $this->agency = $agency;
        $this->expiration = $expiration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $route = Route::where([['agency_id', '=', $this->agency->id], ['route_id', '=', $this->trip['route_id']]])->first();

        $newTrip = new Trip;

        if (isset($route->color)) {
            $newTrip->route_color = $route->color;
            $newTrip->route_short_name = $route->short_name;
            $newTrip->route_long_name = $route->long_name;
        }
        if (isset($route->text_color)) { $newTrip->route_text_color = $route->text_color; };
        $newTrip->agency_id = $this->agency->id;
        $newTrip->expiration = $this->expiration;
        $newTrip->trip_id = $this->trip['trip_id'];
        $newTrip->trip_headsign = $this->trip['trip_headsign'];
        if (isset($this->trip['trip_short_name'])) {
            $newTrip->trip_short_name = $this->trip['trip_short_name'];
        }
        $newTrip->save();
    }
}
