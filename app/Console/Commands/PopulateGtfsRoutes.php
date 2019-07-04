<?php

namespace App\Console\Commands;

use App\Route;
use App\Agency;
use League\Csv\Reader;
use Illuminate\Console\Command;

class PopulateGtfsRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gtfs:addroutes {agency} {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add GTFS routes to the database from CSV file';

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
        $agency = Agency::where('slug' ,$this->argument('agency'))->firstOrFail();
        $filePath = $this->argument('file');

        $csv = Reader::createFromPath(getcwd() . '/' . $filePath, 'r')->setHeaderOffset(0);
        $csvRoutes = $csv->getRecords();

        if ($this->confirm('Do you want to continue? This will add ' . count($csv) . ' routes to the database.')) {
            $bar = $this->output->createProgressBar(count($csv));
            $bar->start();
            foreach ($csvRoutes as $csvRoute) {
                $route = new Route;

                $route->agency_id = $agency->id;
                $route->route_id = $csvRoute['route_id'];
                $route->short_name = $csvRoute['route_short_name'];
                $route->long_name = $csvRoute['route_long_name'];
                $route->color = '#' . $csvRoute['route_color'];
                if ($csvRoute['route_text_color'] == '') {
                    $route->text_color = '#FFFFFF';
                } else {
                    $route->text_color = '#' . $csvRoute['route_text_color'];
                }

                $route->save();
                $bar->advance();
            }
            $bar->finish();
        }

        $this->info('Successful! ' . count($csv) . ' routes added for ' . $agency->name);
    }
}
