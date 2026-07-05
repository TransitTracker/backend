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
        static::created(function () {
            ResponseCache::clear(['links']);
        });

        static::updated(function () {
            ResponseCache::clear(['links']);
        });
    }
}
