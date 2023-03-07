<?php

namespace App\Models\Gtfs;

use App\Models\Trip;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StopTime extends Model
{
    use HasFactory;

    public $guarded = [];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, ['agency_id', 'trip_id'], ['agency_id', 'gtfs_trip_id']);
    }

    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, ['agency_id', 'gtfs_stop_id'], ['agency_id', 'gtfs_stop_id']);
    }
}
