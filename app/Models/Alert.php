<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Alert extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $fillable = ['title', 'body', 'color', 'icon', 'is_active', 'can_be_closed', 'action',
                            'action_parameters', 'expiration', 'image', ];
    public $translatable = ['title', 'body', 'action_parameters'];
    protected $casts = [
        'action_parameters' => 'object',
        'can_be_closed' => 'boolean',
    ];

    protected static function booted()
    {
        static::updated(function () {
            ResponseCache::forget('/api/alert');
            ResponseCache::forget('/v1/alert');
        });
    }

    public function setImageAttribute($value)
    {
        $this->uploadFileToDisk($value, 'image', 'public', 'alerts');
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
