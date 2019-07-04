<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        RefreshSTMVehicles::dispatch(env('STM_APIKEY'))->onQueue('vehicles');
        RefreshSTLVehicles::dispatch()->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'trains')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'rtl')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'citla')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'citvr')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'citlr')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'mrclasso')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'omitsju')->onQueue('vehicles');
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), 'citso')->onQueue('vehicles');
    }
}
