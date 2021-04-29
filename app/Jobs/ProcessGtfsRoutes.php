<?php

namespace App\Jobs;

use App\Models\Agency;
use App\Models\Route;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;

class ProcessGtfsRoutes implements ShouldQueue
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
        // Remove old routes
        Route::whereAgencyId($this->agency->id)->delete();

        $routesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        foreach ($routesReader->getRecords() as $route) {
            // Prepare a new array to update or create the route model
            $newRoute = [];

            // Fill each required attribute
            $newRoute['route_id'] = $route['route_id'];
            $newRoute['short_name'] = $route['route_short_name'];
            $newRoute['long_name'] = $route['route_long_name'];
            if (array_key_exists('route_color', $route)) {
                $newRoute['color'] = '#'.$route['route_color'];
            } else {
                $newRoute['color'] = '#FFFFFF';
            }
            if (array_key_exists('route_text_color', $route)) {
                $newRoute['text_color'] = '#'.$route['route_text_color'];
            } else {
                $newRoute['text_color'] = '#000000';
            }

            // Create or update the route model
            Route::updateOrCreate(['route_id' => $route['route_id'], 'agency_id' => $this->agency->id], $newRoute);
        }
        $routesReader = null;
    }
}
