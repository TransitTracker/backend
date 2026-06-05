<?php

namespace App\Console\Commands\RealtimeData;

use App\Jobs\RealtimeData\SyncGoTransitCarriageDetails;
use Illuminate\Console\Command;

class SyncGoTransitCarriages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realtime:go-carriages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SyncGoTransitCarriageDetails::dispatch()->onQueue('default');

        $this->newLine();
        $this->info('Carriage sync launched for GO Transit!');

        return Command::SUCCESS;
    }
}
