<?php

namespace App;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agency_id', 'active', 'agency', 'gtfs_trip', 'route', 'start', 'vehicle', 'lat', 'lon',
                            'trip_id', 'bearing', 'speed', 'stop_sequence', 'status', 'headsign', 'short_name', 'icon', ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => 'array',
    ];

    /**
     * Get the agency from this vehicle.
     */
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    /**
     * Get the trip from this vehicle.
     */
    public function trip()
    {
        return $this->belongsTo('App\Trip')->withDefault();
    }

    public function links()
    {
        return $this->belongsToMany('App\Link');
    }

    /**
     * Scope a query to only include active agencies.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    protected static function booted()
    {
        static::created(function ($vehicle) {
            $vehicle->icon = $vehicle->agency->vehicles_type;
            $vehicle->links()->attach($vehicle->agency->links->pluck('id'));
            $vehicle->save();
        });
    }
}
