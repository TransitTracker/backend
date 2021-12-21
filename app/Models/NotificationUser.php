<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\HasPushSubscriptions;

class NotificationUser extends Model
{
    use Notifiable;
    use HasPushSubscriptions;

    protected $fillable = [
        'uuid',
        'is_active',
        'is_french',
        'endpoint',
        'expiration',
        'subscribed_general_news',
        'subscribed_electric_stm',
    ];

    protected $hidden = [
        'endpoint',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_french' => 'boolean',
        'subscribed_general_news' => 'boolean',
        'subscribed_electric_stm' => 'boolean',
    ];

    protected $with = ['pushSubscriptions'];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
