<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Region extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'info_title', 'info_body', 'map_box', 'map_zoom', 'credits', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'map_box' => 'array',
        'map_zoom' => 'integer',
    ];

    public $translatable = ['info_title', 'info_body', 'credits', 'description'];

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
     * Get all stats from this region.
     */
    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    protected static function booted()
    {
        static::updated(function (Region $region) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/v1/regions');

            ResponseCache::forget('/v2/regions');
            ResponseCache::forget("/v2/regions/{$region->slug}");
            ResponseCache::forget("/v2/regions/{$region->slug}/alerts");
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
