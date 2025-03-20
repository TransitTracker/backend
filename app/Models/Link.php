<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

class Link extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $translatable = ['title', 'description'];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    protected static function booted()
    {
        static::updated(function (self $link) {
            ResponseCache::forget('/api/links');
            ResponseCache::forget('/v1/links');

            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/links', "/v2/links/{$link->id}")
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/links', "/v2/links/{$link->id}")
                ->forget();
        });
    }
}
