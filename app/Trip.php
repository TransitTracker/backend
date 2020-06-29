<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['agency_id', 'trip_id', 'trip_headsign', 'trip_short_name', 'route_color', 'route_text_color', 'route_short_name', 'route_long_name', 'service_id'];

    /**
     * Get the agency from this vehicle.
     */
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    /**
     * Get all vehicles associated with this trip.
     */
    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    /**
     * Get the service for this trip.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
