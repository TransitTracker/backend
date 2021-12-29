<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Alert
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_active
 * @property string|null $icon
 * @property string $color
 * @property bool $can_be_closed
 * @property array|null $title
 * @property array|null $body
 * @property string|null $action
 * @property AsArrayObject|null $action_parameters
 * @property string|null $expiration
 * @property string|null $image
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static Builder|Alert active()
 * @method static Builder|Alert newModelQuery()
 * @method static Builder|Alert newQuery()
 * @method static Builder|Alert query()
 * @method static Builder|Alert whereAction($value)
 * @method static Builder|Alert whereActionParameters($value)
 * @method static Builder|Alert whereBody($value)
 * @method static Builder|Alert whereCanBeClosed($value)
 * @method static Builder|Alert whereColor($value)
 * @method static Builder|Alert whereCreatedAt($value)
 * @method static Builder|Alert whereExpiration($value)
 * @method static Builder|Alert whereIcon($value)
 * @method static Builder|Alert whereId($value)
 * @method static Builder|Alert whereImage($value)
 * @method static Builder|Alert whereIsActive($value)
 * @method static Builder|Alert whereTitle($value)
 * @method static Builder|Alert whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Alert extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'body', 'color', 'icon', 'is_active', 'can_be_closed', 'action',
                            'action_parameters', 'expiration', 'image', ];

    public $translatable = ['title', 'body'];

    protected $casts = [
        'action_parameters' => AsArrayObject::class,
        'can_be_closed' => 'boolean',
    ];

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIsActive(true)->whereDate('expiration', '>', now());
    }

    protected static function booted()
    {
        static::updated(function (self $alert) {
            ResponseCache::forget('/api/alert');
            ResponseCache::forget('/v1/alert');

            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/alerts', "/v2/alerts/{$alert->id}")
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/alerts', "/v2/alerts/{$alert->id}")
                ->forget();
        });
    }
}
