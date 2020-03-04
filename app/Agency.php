<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'slug', 'static_gtfs_url', 'realtime_url', 'realtime_type', 'realtime_options',
                            'color', 'text_color', 'vehicles_type', 'is_active', 'region_id' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array'
    ];

    /**
     * Get all vehicles from this agency
     */
    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    /**
     * Get all trips from this agency
     */
    public function trips()
    {
        return $this->hasMany('App\Trip');
    }

    /**
     * Get all routes from this agency
     */
    public function routes()
    {
        return $this->hasMany('App\Route');
    }

    /**
     * Get all routes from this agency
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }

    /**
     * Get the region of this agency
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
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
     * Get the realtime method
     *
     * @return string
     */
    public function getRealtimeMethodAttribute()
    {
        if ($this->realtime_options) {
            return json_decode($this->realtime_options)->method;
        } else {
            return null;
        }
    }

    /**
     * Get the realtime options header key
     *
     * @return string
     */
    public function getHeaderNameAttribute()
    {
        if ($this->realtime_options) {
            return key(json_decode($this->realtime_options)->header);
        } else {
            return null;
        }

    }

    /**
     * Get the realtime options header key
     *
     * @return string
     */
    public function getHeaderValueAttribute()
    {
        if ($this->realtime_options) {
            return current(json_decode($this->realtime_options)->header);
        } else {
            return null;
        }
    }

    /**
     * Get the realtime options header key
     *
     * @return string
     */
    public function getParamNameAttribute()
    {
        if ($this->realtime_options) {
            return key(json_decode($this->realtime_options)->param);
        } else {
            return null;
        }
    }

    /**
     * Get the realtime options header key
     *
     * @return string
     */
    public function getParamValueAttribute()
    {
        if ($this->realtime_options) {
            return current(json_decode($this->realtime_options)->param);
        } else {
            return null;
        }
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
}
