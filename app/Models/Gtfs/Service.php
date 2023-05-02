<?php

namespace App\Models\Gtfs;

use App\Models\Agency;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $guarded = [];

    protected $dateFormat = 'Ymd';

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, ['agency_id', 'gtfs_service_id'], ['agency_id', 'gtfs_service_id']);
    }
}
