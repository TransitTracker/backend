<?php

namespace App\Listeners;

use App\Events\VehicleCreated;
use App\Events\VehicleCreating;
use Illuminate\Support\Str;

class CreateVehicleForceLabel
{
    public $queue = 'misc';

    public function __construct()
    {
    }

    public function handle(VehicleCreating $event): bool
    {
        // For Zenbus (for legibility purpose)
        if (Str::startsWith($event->vehicle->vehicle_id, 'zenbus:Vehicle:')) {
            $event->vehicle->force_label = Str::of($event->vehicle->vehicle_id)
                ->remove('enbus:Vehicle')
                ->remove(':LOC')
                ->value();

            return true;
        }

        $event->vehicle->loadMissing('agency');

        // For Metrolinx TMIX agencies
        // The agency prefix is always added in front of vehicles ID
        // See: https://gist.github.com/useless2764/0b3e646f171e8ff5e2721d4a8f234652
        if ($event->vehicle->agency->features->contains('metrolinxTMIX')) {
            $tmixId = (int) $event->vehicle->agency->features
                ->first(fn ($item) => str($item)->startsWith('tmixID:'))
                ->replace('tmixID:', '')
                ->value();

            if (! str($event->vehicle->vehicle_id)->startsWith($tmixId)) {
                // If the vehicle does not start with the correct agency prefix, don't create it
                return false;
            }

            $event->vehicle->force_label = str($event->vehicle->vehicle_id)->replace($tmixId, '')->value();
        }

        return true;
    }
}
