<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\VehiclesUpdated;
use App\Jobs\RefreshSTLVehicles;
use App\Jobs\RefreshSTMVehicles;
use App\Jobs\RefreshExoVehicles;

class UpdateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will refresh all vehicles';

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
        $stmApiKey = env('STM_APIKEY');
        $exoApiKey = env('EXO_APIKEY');

        RefreshSTMVehicles::dispatch($stmApiKey)->onQueue('vehicles');
        RefreshSTLVehicles::dispatch()->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'trains')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'rtl')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citla')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citvr')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citlr')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'mrclasso')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'omitsju')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citrous')->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'mrclm')->onQueue('vehicles');

        event(new VehiclesUpdated(true));
    }
}
