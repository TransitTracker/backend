<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Stop extends Model
{
    use HasFactory;
    use HasSpatial;

    public $guarded = [];

    protected $casts = [
        'position' => Point::class,
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function stopTimes(): HasMany
    {
        return $this->hasMany(StopTime::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id']);
    }
}
