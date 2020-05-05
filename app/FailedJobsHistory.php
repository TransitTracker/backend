<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FailedJobsHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'agency_id', 'exception', 'last_failed'];
}
