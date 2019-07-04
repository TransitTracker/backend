<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'gtfs_id', 'slug'];

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
