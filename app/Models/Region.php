<?php

namespace App\Models;

use Arr;
use Cache;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'info_title', 'info_body', 'map_box', 'map_center', 'map_zoom', 'credits', 'description', 'meta_description', 'image'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'map_box' => 'array',
        'map_center' => AsArrayObject::class,
        'map_zoom' => 'integer',
    ];

    public $translatable = ['info_title', 'info_body', 'credits', 'description', 'meta_description'];

    /**
     * Get all agencies from this region.
     */
    public function agencies()
    {
        return $this->belongsToMany(Agency::class);
    }

    /**
     * Get all active agencies from this region.
     */
    public function activeAgencies()
    {
        return $this->belongsToMany(Agency::class)->active();
    }

    /**
     * Get all alerts from this region.
     */
    public function alerts()
    {
        return $this->belongsToMany(Alert::class);
    }

    /**
     * Get all active alerts from this region.
     */
    public function activeAlerts()
    {
        return $this->belongsToMany(Alert::class)->active();
    }

    /**
     * Get all active vehicles from this region agencies.
     */
    public function vehicles()
    {
        return Vehicle::active()->whereIn('agency_id', $this->activeAgencies->modelKeys());
    }

    /**
     * Get all stats from this region.
     */
    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function getCitiesAttribute()
    {
        return Cache::remember("tt-region-{$this->slug}-cities", 60 * 60 * 24 * 7, function () {
            $allCities = [];
            foreach ($this->activeAgencies as $agency) {
                array_push($allCities, Arr::random($agency->cities));
            }

            return $allCities;
        });
    }

    protected static function booted()
    {
        static::updated(function (self $region) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/v1/regions');

            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/landing', '/v2/regions', "/v2/regions/{$region->slug}", "/v2/regions/{$region->slug}/alerts")
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/landing', '/v2/regions', "/v2/regions/{$region->slug}", "/v2/regions/{$region->slug}/alerts")
                ->forget();
        });
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
}
