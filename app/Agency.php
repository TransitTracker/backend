<?php

namespace App;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Agency extends Model
{
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'static_gtfs_url', 'realtime_url', 'realtime_type', 'realtime_options',
                            'color', 'text_color', 'vehicles_type', 'is_active', 'region_id', ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Get all vehicles from this agency.
     */
    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    /**
     * Get all trips from this agency.
     */
    public function trips()
    {
        return $this->hasMany('App\Trip');
    }

    /**
     * Get all routes from this agency.
     */
    public function routes()
    {
        return $this->hasMany('App\Route');
    }

    /**
     * Get all routes from this agency.
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }

    /**
     * Get the region of this agency.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function links()
    {
        return $this->belongsToMany('App\Link');
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
        static::updated(function ($agency) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/api/vehicles/'.$agency->slug);
            ResponseCache::forget('/api/geojson/'.$agency->slug);
        });
    }
}
