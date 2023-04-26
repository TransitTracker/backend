<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use App\Models\Trip;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Shape extends Model
{
    use HasFactory;
    use HasSpatial;
    use Prunable;

    public $guarded = [];

    protected $casts = [
        'shape' => LineString::class,
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, ['agency_id', 'gtfs_shape_id'], ['agency_id', 'gtfs_shape_id']);
    }

    public function firstTrip(): HasOne
    {
        return $this->hasOne(Trip::class, ['agency_id', 'gtfs_shape_id'], ['agency_id', 'gtfs_shape_id'])->ofMany('gtfs_trip_id', 'MIN');
    }

    // Prune old shapes, that haven't been updated in a year (static GTFS normally get updated more often)
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subYear());
    }
}
