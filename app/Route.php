<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agency_id', 'route_id', 'short_name', 'long_name', 'color', 'text_color'];

    /**
     * Get the agency from this vehicle
     */
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }
}
