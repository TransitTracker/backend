<?php

namespace App\Models;

use App\Events\VehiclesUpdated;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Agency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'short_name', 'slug', 'static_gtfs_url', 'realtime_url', 'realtime_type',
                            'realtime_options', 'color', 'text_color', 'vehicles_type', 'is_active', 'license',
                            'short_name', 'refresh_is_active', 'cron_schedule', 'cities', ];

    protected $fakeColumns = ['license'];

    protected $dispatchesEvents = [
        'updated' => VehiclesUpdated::class,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'license' => 'array',
        'cities' => 'array',
    ];

    /**
     * Get all vehicles from this agency.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get all trips from this agency.
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get all routes from this agency.
     */
    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    /**
     * Get all routes from this agency.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the regions of this agency.
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function links()
    {
        return $this->belongsToMany(Link::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the realtime method.
     *
     * @return string
     */
    public function getRealtimeMethodAttribute()
    {
        return json_decode($this->realtime_options)->realtime_method;
    }

    /**
     * Get the realtime options header key.
     *
     * @return string
     */
    public function getHeaderNameAttribute()
    {
        return json_decode($this->realtime_options)->header_name;
    }

    /**
     * Get the realtime options header key.
     *
     * @return string
     */
    public function getHeaderValueAttribute()
    {
        return json_decode($this->realtime_options)->header_value;
    }

    /**
     * Get the realtime options header key.
     *
     * @return string
     */
    public function getParamNameAttribute()
    {
        return json_decode($this->realtime_options)->param_name;
    }

    /**
     * Get the realtime options header key.
     *
     * @return string
     */
    public function getParamValueAttribute()
    {
        return json_decode($this->realtime_options)->param_value;
    }

    /**
     * Get the custom download method.
     *
     * @return string
     */
    public function getDownloadMethodAttribute()
    {
        return json_decode($this->realtime_options)->download_method ?? '';
    }

    public function getRandomCitiesAttribute()
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

    /**
     * Scope a query to only include active agencies.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    protected static function booted()
    {
        static::updated(function (self $agency) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/v1/regions');
            ResponseCache::forget("/api/vehicles/{$agency->slug}");
            ResponseCache::forget("/v1/vehicles/{$agency->slug}");

            ResponseCache::forget('/v2/agencies');
            ResponseCache::forget("/v2/agencies/{$agency->slug}");
            ResponseCache::forget("/v2/agencies/{$agency->slug}/vehicles");
        });
    }
}
