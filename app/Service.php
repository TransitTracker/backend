<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['service_id', 'start_date', 'end_date', 'agency_id'];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Ymd';

    /**
     * Get the agency of this trip
     */
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    /**
     * Get all trips with this service
     */
    public function trips()
    {
        return $this->hasMany('App\Trip');
    }
}
