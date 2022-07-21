<?php

namespace App\Models;

use App\Events\NotificationUserCreated;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\HasPushSubscriptions;

class NotificationUser extends Model implements HasLocalePreference
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

    protected $with = [
        'pushSubscriptions',
        'agencies:id,slug',
        'vehicles:id,label,force_label,vehicle,icon,agency_id',
        'vehicles.agency:id,slug',
    ];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public function preferredLocale(): string
    {
        return $this->is_french ? 'fr' : 'en';
    }

    protected $dispatchesEvents = [
        'created' => NotificationUserCreated::class,
    ];

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
