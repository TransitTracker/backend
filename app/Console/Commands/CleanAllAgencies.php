<?php

namespace App\Console\Commands;

use App\Models\Agency;
use App\Jobs\CleanGtfsData;
use Illuminate\Console\Command;

class CleanAllAgencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:clean-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will clean GTFS data for all agencies';

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
        // Get all agencies
        $agencies = Agency::all();

        // Clean each agency
        foreach ($agencies as $agency) {
            CleanGtfsData::dispatch($agency)->onQueue('gtfs');
        }
    }
}
