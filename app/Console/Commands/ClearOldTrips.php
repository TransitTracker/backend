<?php

namespace App\Console\Commands;

use App\Trip;
use Illuminate\Console\Command;

class ClearOldTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trips:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all expired trips';

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
        $date = date('Ymd');
        $expiredTrips = Trip::where('expiration', '>', $date);

        if ($this->confirm('Do you want to continue? This will delete ' .  $expiredTrips->count() . ' trips.')) {
            $expiredTrips->delete();
        };
    }
}
