<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'slug', 'info_title', 'info_body', 'map_box', 'map_zoom', 'conditions', 'credits',
                            'map' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'info_title' => 'array',
        'info_body' => 'array',
        'map_box' => 'array',
        'map_zoom' => 'integer',
        'conditions' => 'array',
        'credits' => 'array',
    ];

    /**
     * Get all agencies from this region
     */
    public function agencies()
    {
        return $this->hasMany('App\Agency');
    }

    /**
     * Get all active agencies from this region
     */
    public function activeAgencies()
    {
        return $this->hasMany('App\Agency')->active();
    }

    /**
     * Get all alerts from this region
     */
    public function alerts()
    {
        return $this->hasMany('App\Alert');
    }

    /**
     * Get all stats from this region
     */
    public function stats()
    {
        return $this->hasMany('App\Stats');
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
