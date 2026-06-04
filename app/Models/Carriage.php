<?php

namespace App\Models;

use App\Enums\OccupancyStatus;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Carriage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'occupancy_status' => OccupancyStatus::class,
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, ['agency_id', 'vehicle_id'], ['agency_id', 'vehicle_id']);
    }

    public function carriageType(): BelongsTo
    {
        return $this->belongsTo(CarriageType::class);
    }

    protected function displayedLabel(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['label'] ?? $attributes['carriage_id'],
        );
    }
}
