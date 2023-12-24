<?php

namespace App\Listeners;

use App\Enums\AgencyFeature;
use App\Events\VehicleTripChanged;
use App\Events\VehicleUpdated;
use App\Models\Gtfs\PredictedBlock;
use App\Models\Gtfs\Trip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PredictBlock implements ShouldQueue
{
    public $queue = 'misc';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VehicleTripChanged $event): void
    {
        $event->vehicle->loadMissing(['agency:id,features']);

        if (!$event->vehicle->agency->features->contains(AgencyFeature::PredictedBlocks)) {
            return;
        }

        if (empty($event->vehicle->gtfs_trip_id)) {
            return;
        }

        // The theory of this feature is simple
        // If a trip does not have a block_id, set it as the vehicle_id
        // On a given day, the vehicle will travel through multiple trips and mark them as a signe block
        Trip::query()
            ->whereBelongsTo($event->vehicle->agency)
            ->where(['gtfs_trip_id' => $event->vehicle->gtfs_trip_id])
            ->whereNull('gtfs_block_id')
            ->update(['gtfs_block_id' => $event->vehicle->id]);
    }
}
