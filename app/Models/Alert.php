<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

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
