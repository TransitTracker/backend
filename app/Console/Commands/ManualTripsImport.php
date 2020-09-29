<?php

namespace App\Console\Commands;

use App\Models\Route;
use App\Models\Service;
use App\Models\Trip;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ManualTripsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trips:import {file} {agencyId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually import trips from specified file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tripsReader = Reader::createFromPath($this->argument('file'))->setHeaderOffset(0);
        $this->line('Starting the import process.');
        $bar = $this->output->createProgressBar(count($tripsReader));
        $bar->start();

        foreach ($tripsReader->getRecords() as $trip) {
            $bar->advance();
            // Find the route and service matching this trip
            $route = Route::where([['agency_id', $this->argument('agencyId')], ['route_id', $trip['route_id']]])->first();
            $service = Service::where([['agency_id', $this->argument('agencyId')], ['service_id', $trip['service_id']]])->first();

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

                // Create or update the trip model
                Trip::updateOrCreate(['trip_id' => $trip['trip_id'], 'agency_id' => $this->argument('agencyId')], $newTrip);
            } else {
                $this->error("Trip #{$trip['trip_id']} will not be imported.");
            }
        }
        $tripsReader = null;
        $bar->finish();
        $this->line('');
        $this->info('Success!');
    }
}
