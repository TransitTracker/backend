<?php

namespace App\Models;

use App\Events\VehiclesUpdated;
use App\Models\Gtfs\Route;
use App\Models\Gtfs\Service;
use App\Models\Gtfs\Shape;
use App\Models\Gtfs\Stop;
use App\Models\Gtfs\StopTime;
use App\Models\Gtfs\Trip;
use Arr;
use Google\Service\CloudBuild\Build;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;
use URL;

class Agency extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'license' => 'array',
        'cities' => 'array',
        'headers' => 'array',
        'is_active' => 'bool',
        'refresh_is_active' => 'bool',
        'is_exo_sector' => 'bool',
    ];

    // MySQL can't have default value, this sets headers to an empty array
    protected $attributes = [
        'headers' => '{}',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /*
     * Relationships
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function shapes(): HasMany
    {
        return $this->hasMany(Shape::class);
    }

    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class);
    }

    public function stopTimes(): HasMany
    {
        return $this->hasMany(StopTime::class);
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
    }

    public function notificationUsers(): BelongsToMany
    {
        return $this->belongsToMany(NotificationUser::class);
    }

    public function activeNotificationUsers(): BelongsToMany
    {
        return $this->belongsToMany(NotificationUser::class)->active();
    }

    public function exoWithVin(): HasMany
    {
        return $this->hasMany(Vehicle::class)->exoWithVin();
    }

    /*
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public function scopeExo(Builder $query): Builder
    {
        return $query->whereIn('id', Cache::get('exoAgenciesId', []));
    }

    /*
     * Others
     */
    public function getRandomCitiesAttribute(): array
    {
        $cities = $this->cities;
        if (!$cities) {
            return [];
        }

        if (count($cities) < 5) {
            return $cities;
        }

        return Arr::random($cities, 5);
    }

    public function signedUpdateGtfsUrl(): string
    {
        return URL::temporarySignedRoute('internal.agencies.static-update', now()->addHours(12), [
            'agency' => $this,
        ]);
    }

    /*
     * Events
     */
    protected $dispatchesEvents = [
        'updated' => VehiclesUpdated::class,
    ];

    protected static function booted(): void
    {
        static::updated(function (self $agency) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/v1/regions');
            ResponseCache::forget("/api/vehicles/{$agency->slug}");
            ResponseCache::forget("/v1/vehicles/{$agency->slug}");

            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/agencies', "/v2/agencies/{$agency->slug}", "/v2/agencies/{$agency->slug}/vehicles", '/v2/regions')
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/agencies', "/v2/agencies/{$agency->slug}", "/v2/agencies/{$agency->slug}/vehicles", '/v2/regions')
                ->forget();

            if ($agency->wasChanged('is_exo_sector')) {
                // TODO: Verify it works test?
                Cache::forever('exoAgenciesId', Agency::where('is_exo_sector', true)->select('id')->get()->pluck('id')->all());
                Cache::forget('exoSectors');
                Cache::forget('exoOperators');
            }
        });
    }
}
