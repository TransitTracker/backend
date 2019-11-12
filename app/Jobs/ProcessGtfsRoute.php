<?php

namespace App\Jobs;

use App\Agency;
use App\Route;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGtfsRoute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;
    private $route;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param $route
     */
    public function __construct(Agency $agency, $route)
    {
        $this->agency = $agency;
        $this->route = $route;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Prepare a new array to update or create the route model
        $newRoute = [];

        // Fill each required attribute
        $newRoute['route_id'] = $this->route['route_id'];
        $newRoute['short_name'] = $this->route['route_short_name'];
        $newRoute['long_name'] = $this->route['route_long_name'];
        if (array_key_exists('route_color', $this->route)) {
            $newRoute['color'] = '#' . $this->route['route_color'];
        } else {
            $newRoute['color'] = '#FFFFFF';
        }
        if (array_key_exists('route_text_color', $this->route)) {
            $newRoute['text_color'] = '#' . $this->route['route_text_color'];
        } else {
            $newRoute['text_color'] = '#000000';
        }

        // Create or update the route model
        Route::updateOrCreate(['route_id' => $this->route['route_id'], 'agency_id' => $this->agency->id], $newRoute);
    }
}
