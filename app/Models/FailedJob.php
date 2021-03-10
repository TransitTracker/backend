<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use URL;

class FailedJob extends Model
{
    protected $table = 'failed_jobs_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'agency_id', 'snooze', 'exception'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * @param int $hours
     * @return string
     */
    public function signedSnoozeUrl(int $hours)
    {
        return URL::temporarySignedRoute('signed.snooze', now()->addHour(), [
            'failedJob' => $this,
            'hours' => $hours,
        ]);
    }
}
