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

        $time = time();

        RefreshSTMVehicles::dispatch($stmApiKey, $time)->onQueue('vehicles');
        RefreshSTLVehicles::dispatch($time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'trains', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'rtl', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citla', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citvr', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citlr', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'mrclasso', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'omitsju', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citrous', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'mrclm', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citso', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'cithsl', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citpi', $time)->onQueue('vehicles');
        RefreshExoVehicles::dispatch($exoApiKey, 'citsv', $time)->onQueue('vehicles');
    }
}
