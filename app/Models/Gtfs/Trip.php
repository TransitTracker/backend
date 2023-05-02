<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use App\Models\Vehicle;
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

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class, ['agency_id', 'gtfs_route_id'], ['agency_id', 'gtfs_route_id']);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, ['agency_id', 'gtfs_service_id'], ['agency_id', 'gtfs_service_id'])->withDefault();
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
        return $this->hasOne(StopTime::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id'])->ofMany('sequence', 'MIN');
    }
}
