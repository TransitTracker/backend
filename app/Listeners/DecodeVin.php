<?php

namespace App\Listeners;

use App\Events\VehicleCreated;
use App\Events\VehicleForceRefAdded;
use App\Jobs\Vin\DecodeVin as DecodeVinJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class DecodeVin implements ShouldQueue
{
    public $queue = 'misc';

    public function __construct()
    {
    }

    public function handle(VehicleCreated|VehicleForceRefAdded $event)
    {
        if (! $event->vehicle->isExoVin()) {
            return false;
        }

        DecodeVinJob::dispatchSync([$event->vehicle->force_ref ?? $event->vehicle->vehicle]);
    }
}
