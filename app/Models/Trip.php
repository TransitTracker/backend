<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Trip
 *
 * @property int $id
 * @property int|null $agency_id
 * @property string $trip_id
 * @property string $trip_headsign
 * @property string|null $trip_short_name
 * @property string|null $route_color
 * @property string|null $route_text_color
 * @property string|null $route_short_name
 * @property string|null $route_long_name
 * @property string $expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $service_id
 * @property string|null $shape
 * @property-read \App\Models\Agency|null $agency
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereShape($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripHeadsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Trip extends Model
{
    protected $fillable = ['agency_id', 'trip_id', 'trip_headsign', 'trip_short_name', 'route_color',
                            'route_text_color', 'route_short_name', 'route_long_name', 'service_id', 'shape', ];

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
}
