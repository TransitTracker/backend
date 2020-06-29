<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'data', 'region_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'object',
    ];

    /**
     * Get the region of this agency.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
