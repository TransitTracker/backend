<?php

namespace App\Console\Commands\Migration;

use App\Models\Agency;
use App\Models\Region;
use Illuminate\Console\Command;

class TransferMapBoxToMapCenter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:mapbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer agencies map_box to map_center';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Starting migrating agencies map_box field to the new map_center field.');

        $this->withProgressBar(Region::all(), function ($region) {
            $region->map_center['lat'] = $region->map_box[1];
            $region->map_center['lon'] = $region->map_box[0];
            $region->save();
        });

        $this->info(' Completed!');
    }
}
