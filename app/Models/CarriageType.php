<?php

namespace App\Models;

use App\Enums\CarriageCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ResponseCache;

class CarriageType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'carriage_category' => CarriageCategory::class,
        'automatic_mappings' => 'array',
    ];

    public function carriages(): HasMany
    {
        return $this->hasMany(Carriage::class);
    }

    protected static function booted(): void
    {
        static::created(function () {
            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/carriageTypes')
                ->forget();

            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/carriageTypes')
                ->forget();
        });

        static::updated(function () {
            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/carriageTypes')
                ->forget();

            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/carriageTypes')
                ->forget();
        });
    }
}
