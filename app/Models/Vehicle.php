<?php

namespace App\Models;

use App\Events\ElectricStmVehicleUpdated;
use App\Events\VehicleCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ResponseCache\Facades\ResponseCache;

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

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class)->withDefault();
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
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
        // return $query->where([['agency_id', '>=', 5], ['agency_id', '<=', 16]]);
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
        if (
            ! Carbon::parse($this->getOriginal('updated_at'))->isCurrentDay() &&
            $this->updated_at->isCurrentDay()
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

            ElectricStmVehicleUpdated::dispatchIf(($vehicle->isFirstAppearanceToday() && $vehicle->isElectricStm()), $vehicle);
        });
    }
}
