<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;

class StopTime extends Model
{
    public $guarded = [];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id']);
    }

    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, ['agency_id', 'gtfs_stop_id'], ['agency_id', 'gtfs_stop_id']);
    }
}
