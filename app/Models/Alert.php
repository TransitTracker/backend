<?php

namespace App\Models;

use App\Enums\AlertCategory;
use App\Enums\AlertStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

class Alert extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['title', 'subtitle', 'body'];

    protected $casts = [
        'action_parameters' => AsArrayObject::class,
        'is_regional' => 'boolean',
        'status' => AlertStatus::class,
        'category' => AlertCategory::class,
        'new_status' => AlertStatus::class,
        'new_status_date' => 'date',
    ];

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', [
            AlertStatus::Active,
            AlertStatus::Locked,
        ]);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereIn('status', [
            AlertStatus::Active,
            AlertStatus::Locked,
            AlertStatus::Archived,
        ]);
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
