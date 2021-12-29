<?php

namespace App\Models;

use Arr;
use Cache;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'info_title', 'info_body', 'map_box', 'map_center', 'map_zoom', 'credits', 'description', 'meta_description', 'image'];

    protected $casts = [
        'map_box' => 'array',
        'map_center' => AsArrayObject::class,
        'map_zoom' => 'integer',
    ];

    public $translatable = ['info_title', 'info_body', 'credits', 'description', 'meta_description'];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function activeAgencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class)->active();
    }

    public function alerts(): BelongsToMany
    {
        return $this->belongsToMany(Alert::class);
    }

    public function activeAlerts(): BelongsToMany
    {
        return $this->belongsToMany(Alert::class)->active();
    }

    public function vehicles(): QueryBuilder
    {
        return Vehicle::active()->whereIn('agency_id', $this->activeAgencies->modelKeys());
    }

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class);
    }

    public function getCitiesAttribute(): array
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
