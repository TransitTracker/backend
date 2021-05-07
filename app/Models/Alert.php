<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

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

    protected static function booted()
    {
        static::updated(function (Alert $alert) {
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

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(true)->whereDate('expiration', '>', now());
    }
}
