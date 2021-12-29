<?php

namespace App\Models;

use App\Events\VehiclesUpdated;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use URL;

/**
 * App\Models\Agency
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $vehicles_type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $timestamp
 * @property string $text_color
 * @property array|null $tags
 * @property int $is_active
 * @property string|null $static_gtfs_url
 * @property string|null $realtime_url
 * @property string|null $realtime_type
 * @property mixed|null $realtime_options
 * @property array|null $license
 * @property int $refresh_is_active
 * @property string|null $short_name
 * @property string $cron_schedule
 * @property array|null $cities
 * @property string|null $static_etag
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $activeNotificationUsers
 * @property-read int|null $active_notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoLabelledVehicles
 * @property-read int|null $exo_labelled_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoUnlabelledVehicles
 * @property-read int|null $exo_unlabelled_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoWithVin
 * @property-read int|null $exo_with_vin_count
 * @property-read string $download_method
 * @property-read string $header_name
 * @property-read string $header_value
 * @property-read string $param_name
 * @property-read string $param_value
 * @property-read array $random_cities
 * @property-read string $realtime_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $notificationUsers
 * @property-read int|null $notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Route[] $routes
 * @property-read int|null $routes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static Builder|Agency active()
 * @method static Builder|Agency newModelQuery()
 * @method static Builder|Agency newQuery()
 * @method static Builder|Agency query()
 * @method static Builder|Agency whereCities($value)
 * @method static Builder|Agency whereColor($value)
 * @method static Builder|Agency whereCreatedAt($value)
 * @method static Builder|Agency whereCronSchedule($value)
 * @method static Builder|Agency whereId($value)
 * @method static Builder|Agency whereIsActive($value)
 * @method static Builder|Agency whereLicense($value)
 * @method static Builder|Agency whereName($value)
 * @method static Builder|Agency whereRealtimeOptions($value)
 * @method static Builder|Agency whereRealtimeType($value)
 * @method static Builder|Agency whereRealtimeUrl($value)
 * @method static Builder|Agency whereRefreshIsActive($value)
 * @method static Builder|Agency whereShortName($value)
 * @method static Builder|Agency whereSlug($value)
 * @method static Builder|Agency whereStaticEtag($value)
 * @method static Builder|Agency whereStaticGtfsUrl($value)
 * @method static Builder|Agency whereTags($value)
 * @method static Builder|Agency whereTextColor($value)
 * @method static Builder|Agency whereTimestamp($value)
 * @method static Builder|Agency whereUpdatedAt($value)
 * @method static Builder|Agency whereVehiclesType($value)
 * @mixin \Eloquent
 */
class Agency extends Model
{
    protected $fillable = ['name', 'short_name', 'slug', 'static_gtfs_url', 'realtime_url', 'realtime_type',
                            'realtime_options', 'color', 'text_color', 'vehicles_type', 'is_active', 'license',
                            'short_name', 'refresh_is_active', 'cron_schedule', 'cities', 'static_etag', ];

    protected $casts = [
        'tags' => 'array',
        'license' => 'array',
        'cities' => 'array',
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

    public function exoLabelledVehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class)->exoLabelled();
    }

    public function exoUnlabelledVehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class)->exoUnlabelled();
    }

    /*
     * Accessors
     */
    public function getRealtimeMethodAttribute(): string
    {
        return json_decode($this->realtime_options)->realtime_method;
    }

    public function getHeaderNameAttribute(): string
    {
        return json_decode($this->realtime_options)->header_name;
    }

    public function getHeaderValueAttribute(): string
    {
        return json_decode($this->realtime_options)->header_value;
    }

    public function getParamNameAttribute(): string
    {
        return json_decode($this->realtime_options)->param_name;
    }

    public function getParamValueAttribute(): string
    {
        return json_decode($this->realtime_options)->param_value;
    }

    public function getDownloadMethodAttribute(): string
    {
        return json_decode($this->realtime_options)->download_method ?? '';
    }

    /*
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    /*
     * Others
     */
    public function getRandomCitiesAttribute(): array
    {
        $cities = $this->cities;
        if (! $cities) {
            return [];
        }

        if (count($cities) < 5) {
            return $cities;
        }

        return Arr::random($cities, 5);
    }

    public function signedUpdateGtfsUrl(): string
    {
        return URL::temporarySignedRoute('admin.agencies.update', now()->addHours(12), [
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
        });
    }
}
