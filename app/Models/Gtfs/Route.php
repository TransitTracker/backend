<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    protected $guarded = [];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, ['agency_id', 'gtfs_route_id'], ['agency_id', 'gtfs_route_id']);
    }
}
