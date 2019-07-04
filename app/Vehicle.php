<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'agency_id', 'active', 'agency', 'gtfs_trip', 'route', 'start', 'vehicle', 'lat', 'lon',
                            'trip_id', 'bearing', 'speed', 'stop_sequence', 'status', 'headsign', 'short_name' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => 'array'
    ];

    /**
     * Get the agency from this vehicle
     */
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    /**
     * Get the trip from this vehicle
     */
    public function trip()
    {
        return $this->belongsTo('App\Trip')->withDefault();
    }

}
