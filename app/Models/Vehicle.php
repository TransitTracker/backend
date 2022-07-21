<?php

namespace App\Models;

use App\Events\ElectricStmVehicleUpdated;
use App\Events\VehicleCreated;
use App\Events\VehicleUpdated;
use App\Services\Vin\VinInterface;
use App\Services\Vin\VinManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * App\Models\Vehicle.
 *
 * @property int $id
 * @property bool $active
 * @property int|null $agency_id
 * @property string|null $gtfs_trip
 * @property string $route
 * @property string|null $start
 * @property string $vehicle
 * @property float|null $lat
 * @property float|null $lon
 * @property float|null $bearing
 * @property float|null $speed
 * @property int|null $stop_sequence
 * @property int|null $status
 * @property int|null $trip_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $icon
 * @property int|null $relationship
 * @property string|null $label
 * @property string|null $force_label
 * @property string|null $plate
 * @property string|null $odometer
 * @property string|null $timestamp
 * @property int|null $congestion
 * @property int|null $occupancy
 * @property-read \App\Models\Agency|null $agency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \App\Models\Trip|null $trip
 * @method static Builder|Vehicle active()
 * @method static Builder|Vehicle downloadable()
 * @method static Builder|Vehicle exo()
 * @method static Builder|Vehicle exoLabelled()
 * @method static Builder|Vehicle exoUnlabelled()
 * @method static Builder|Vehicle exoWithVin()
 * @method static Builder|Vehicle newModelQuery()
 * @method static Builder|Vehicle newQuery()
 * @method static Builder|Vehicle query()
 * @method static Builder|Vehicle whereActive($value)
 * @method static Builder|Vehicle whereAgencyId($value)
 * @method static Builder|Vehicle whereBearing($value)
 * @method static Builder|Vehicle whereCongestion($value)
 * @method static Builder|Vehicle whereCreatedAt($value)
 * @method static Builder|Vehicle whereForceLabel($value)
 * @method static Builder|Vehicle whereGtfsTrip($value)
 * @method static Builder|Vehicle whereIcon($value)
 * @method static Builder|Vehicle whereId($value)
 * @method static Builder|Vehicle whereLabel($value)
 * @method static Builder|Vehicle whereLat($value)
 * @method static Builder|Vehicle whereLon($value)
 * @method static Builder|Vehicle whereOccupancy($value)
 * @method static Builder|Vehicle whereOdometer($value)
 * @method static Builder|Vehicle wherePlate($value)
 * @method static Builder|Vehicle whereRelationship($value)
 * @method static Builder|Vehicle whereRoute($value)
 * @method static Builder|Vehicle whereSpeed($value)
 * @method static Builder|Vehicle whereStart($value)
 * @method static Builder|Vehicle whereStatus($value)
 * @method static Builder|Vehicle whereStopSequence($value)
 * @method static Builder|Vehicle whereTimestamp($value)
 * @method static Builder|Vehicle whereTripId($value)
 * @method static Builder|Vehicle whereUpdatedAt($value)
 * @method static Builder|Vehicle whereVehicle($value)
 * @method static Builder|Vehicle withoutTouch()
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    protected $fillable = ['agency_id', 'active', 'agency', 'gtfs_trip', 'route', 'start', 'vehicle', 'lat', 'lon',
                            'trip_id', 'bearing', 'speed', 'stop_sequence', 'status', 'headsign', 'short_name', 'icon',
                            'relationship', 'label', 'force_label', 'plate', 'odometer', 'timestamp', 'congestion', 'occupancy', ];

    protected $casts = [
        'active' => 'boolean',
        'coordinates' => 'array',
    ];

    /*
     * Relationships
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
    }

    public function notificationUsers(): BelongsToMany
    {
        return $this->belongsToMany(NotificationUser::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class)->withDefault();
    }

    public function relatedVehicles(): HasMany
    {
        return $this->hasMany(self::class, 'vehicle', 'vehicle');
    }

    /*
     * Accessor
     */
    public function getDisplayedLabelAttribute(): string
    {
        return $this->force_label ?? $this->label ?? $this->vehicle;
    }

    protected function vinInfo(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes): VinInterface {
                if (!$this->isExoVin()) {
                    return new \App\Services\Vin\EmptyVinInterface();
                }

                return VinManager::getInfo($attributes['vehicle']);
            },
        )->shouldCache();
    }

    /*
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }

    public function scopeDownloadable(Builder $query): Builder
    {
        // Todo: make this function dynamic
        return $query->whereNotIn('agency_id', [28]);
    }

    public function scopeWithoutTouch(Builder $query): Builder
    {
        $this->timestamps = false;

        return $query;
    }

    public function scopeExo(Builder $query): Builder
    {
        return $query->where([['agency_id', '>=', 5], ['agency_id', '<=', 16]]);
    }

    public function scopeExoWithVin(Builder $query): Builder
    {
        return $query->where([['agency_id', '>=', 5], ['agency_id', '<=', 16]])
            ->whereDate('created_at', '>=', '2021-04-27');
    }

    public function scopeExoLabelled(Builder $query): Builder
    {
        return $query->where([['force_label', '<>', null], ['agency_id', '>=', 5], ['agency_id', '<=', 16]])
            ->whereDate('created_at', '>=', '2021-04-27');
    }

    public function scopeExoUnlabelled(Builder $query): Builder
    {
        return $query->where([['force_label', '=', null], ['agency_id', '>=', 5], ['agency_id', '<=', 16]])
            ->whereDate('created_at', '>=', '2021-04-27');
    }

    /*
     * Others
     */
    public function isFirstAppearanceToday(): bool
    {
        if (!$this->getOriginal('updated_at')) {
            return false;
        }
        
        // Use subHours(4) to not count 0 a.m. to 4 a.m. in the current day (night routes)
        if (
            ! $this->getOriginal('updated_at')->subHours(4)->isCurrentDay() &&
            $this->updated_at->subHours(4)->isCurrentDay()
        ) {
            return true;
        }

        return false;
    }

    public function isElectricStm(): bool
    {
        if ($this->agency_id !== 1) {
            return false;
        }

        $vehicle = intval($this->vehicle);

        if ((40901 <= $vehicle) && ($vehicle <= 40930)) {
            return true;
        }

        return false;
    }

    public function isExoVin(): bool
    {
        if (($this->agency_id < 5) || ($this->agency_id > 16)) {
            return false;
        }

        if ($this->created_at->isBefore('2021-04-27')) {
            return false;
        }
        
        return true;
    }

    /*
     * Events
     */
    protected $dispatchesEvents = [
        'created' => VehicleCreated::class,
    ];

    protected static function booted()
    {
        static::created(function (self $vehicle) {
            $vehicle->icon = $vehicle->agency->vehicles_type;
            $vehicle->links()->attach($vehicle->agency->links->pluck('id'));
            $vehicle->save();
        });

        static::updated(function (self $vehicle) {
            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls("/v2/vehicles/{$vehicle->id}")
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls("/v2/vehicles/{$vehicle->id}")
                ->forget();
            
            VehicleUpdated::dispatchIf($vehicle->isFirstAppearanceToday(), $vehicle);

            ElectricStmVehicleUpdated::dispatchIf(($vehicle->isFirstAppearanceToday() && $vehicle->isElectricStm()), $vehicle);
        });
    }
}
