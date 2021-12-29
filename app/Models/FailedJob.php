<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use URL;

/**
 * App\Models\FailedJob
 *
 * @property int $id
 * @property string $name
 * @property int|null $agency_id
 * @property string $exception
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $snooze
 * @property-read \App\Models\Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereSnooze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FailedJob extends Model
{
    protected $table = 'failed_jobs_histories';

    protected $fillable = ['name', 'agency_id', 'snooze', 'exception'];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function signedSnoozeUrl(int $hours): string
    {
        return URL::temporarySignedRoute('signed.snooze', now()->addHours(5), [
            'failedJob' => $this,
            'hours' => $hours,
        ]);
    }
}
