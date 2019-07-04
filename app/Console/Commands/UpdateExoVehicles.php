<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RefreshExoVehicles;

class UpdateExoVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:exorefresh {sectorkey}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will refresh exo specified sector vehicles data';

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
        RefreshExoVehicles::dispatch(env('EXO_APIKEY'), $this->argument('sectorkey'))->onQueue('vehicles');
    }
}
