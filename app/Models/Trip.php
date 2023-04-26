<?php

namespace App\Models;

use App\Models\Gtfs\Shape;
use App\Models\Gtfs\StopTime;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Awobaz\Compoships\Database\Eloquent\Relations\HasOne;

class Trip extends Model
{
    protected $guarded = [];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }

    public function shape(): BelongsTo
    {
        return $this->belongsTo(Shape::class, ['agency_id', 'gtfs_shape_id'], ['agency_id', 'gtfs_shape_id']);
    }

    public function stopTimes(): HasMany
    {
        return $this->hasMany(StopTime::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id']);
    }

    public function firstDeparture(): HasOne
    {
        return $this->hasOne(StopTime::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id'])->ofMany('sequence', 'min');
    }
}
