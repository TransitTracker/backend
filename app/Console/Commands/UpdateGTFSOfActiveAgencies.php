<?php

namespace App\Console\Commands;

use App\Agency;
use App\Jobs\CleanGtfsData;
use App\Jobs\DownloadGTFS;
use Illuminate\Console\Command;

class UpdateGTFSOfActiveAgencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:update-actives';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update GTFS data for all active agencies';

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
        $agencies = Agency::where('is_active', 1)->get();

        // Clean each agency
        foreach ($agencies as $agency) {
            DownloadGTFS::dispatch($agency)->onQueue('gtfs');
        }
    }
}
