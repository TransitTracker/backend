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

/**
 * App\Models\NotificationUser
 *
 * @property int $id
 * @property string $uuid
 * @property bool $is_active
 * @property bool $is_french
 * @property string $endpoint
 * @property string|null $expiration
 * @property bool $subscribed_general_news
 * @property bool $subscribed_electric_stm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @method static Builder|NotificationUser active()
 * @method static Builder|NotificationUser newModelQuery()
 * @method static Builder|NotificationUser newQuery()
 * @method static Builder|NotificationUser query()
 * @method static Builder|NotificationUser whereCreatedAt($value)
 * @method static Builder|NotificationUser whereEndpoint($value)
 * @method static Builder|NotificationUser whereExpiration($value)
 * @method static Builder|NotificationUser whereId($value)
 * @method static Builder|NotificationUser whereIsActive($value)
 * @method static Builder|NotificationUser whereIsFrench($value)
 * @method static Builder|NotificationUser whereSubscribedElectricStm($value)
 * @method static Builder|NotificationUser whereSubscribedGeneralNews($value)
 * @method static Builder|NotificationUser whereUpdatedAt($value)
 * @method static Builder|NotificationUser whereUuid($value)
 * @mixin \Eloquent
 */
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

    protected $with = ['pushSubscriptions'];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
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
