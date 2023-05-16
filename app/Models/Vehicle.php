<?php

namespace App\Models;

use App\Enums\VehicleType;
use App\Events\ElectricStmVehicleUpdated;
use App\Events\VehicleCreated;
use App\Events\VehicleForceRefAdded;
use App\Events\VehicleUpdated;
use App\Models\Gtfs\Route;
use App\Models\Gtfs\Trip;
use App\Models\Vin\Information;
use Awobaz\Compoships\Database\Eloquent\Model;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Spatie\ResponseCache\Facades\ResponseCache;

class Vehicle extends Model
{
    use HasSpatial;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => Point::class,
        'vehicle_type' => VehicleType::class,
    ];

    /*
     * Relationships
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function allTags()
    {
        return [];
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
    }

    public function notificationUsers(): BelongsToMany
    {
        return $this->belongsToMany(NotificationUser::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, ['agency_id', 'gtfs_trip_id'], ['agency_id', 'gtfs_trip_id'])->withDefault();
    }

    public function relatedVehicles(): HasMany
    {
        return $this->hasMany(self::class, 'vehicle_id', 'vehicle_id');
    }

    // TODO: Rename to route once field has been removed
    public function gtfsRoute(): BelongsTo
    {
        return $this->belongsTo(Route::class, ['agency_id', 'gtfs_route_id'], ['agency_id', 'gtfs_route_id']);
    }

    public function vinInformationForceRef(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'force_vehicle_id', 'vin')->withDefault();
    }

    public function vinInformationRef(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'vehicle_id', 'vin')->withDefault();
    }

    public function vinInformation(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->relationLoaded('vinInformationForceRef')) {
                    return $this->getRelation('vinInformationForceRef');
                }

                $this->load('vinInformationRef');

                return $this->getRelation('vinInformationRef');
            }
        );
    }

    /*
     * Accessor
     */
    public function getDisplayedLabelAttribute(): string
    {
        return $this->force_label ?? $this->label ?? $this->force_vehicle_id ?? $this->vehicle_id;
    }

    public function getRefAttribute(): string
    {
        return $this->force_vehicle_id ?? $this->vehicle_id;
    }

    /*
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
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
            ->whereDate('created_at', '>=', '2021-04-27')
            ->whereRaw('LENGTH(vehicle_id) = ?', [17]);
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

    public function scopeWithoutTypeOfTags(Builder $query, int $type): Builder
    {
        return $query->whereDoesntHave('tags', fn (Builder $query) => $query->where('type', $type));
    }

    /*
     * Others
     */
    public function isFirstAppearanceToday(): bool
    {
        if (! $this->getOriginal('updated_at')) {
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

        $vehicle = intval($this->vehicle_id);

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

    protected static function booted(): void
    {
        static::created(function (self $vehicle) {
            $vehicle->loadMissing(['agency:id,vehicles_type', 'agency.links:id']);
            $vehicle->vehicle_type = VehicleType::coerce(Str::ucfirst($vehicle->agency->vehicles_type));
            $vehicle->save();
            $vehicle->links()->attach($vehicle->agency->links->pluck('id')->all());
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
            VehicleForceRefAdded::dispatchIf($vehicle->wasChanged('force_vehicle_id'), $vehicle);

            ElectricStmVehicleUpdated::dispatchIf(($vehicle->isFirstAppearanceToday() && $vehicle->isElectricStm()), $vehicle);
        });
    }
}
