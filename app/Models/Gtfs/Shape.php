<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use App\Models\Trip;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Shape extends Model
{
    use HasFactory;
    use HasSpatial;

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
}
