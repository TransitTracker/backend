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

    protected $fillable = ['title', 'body', 'color', 'icon', 'is_active', 'can_be_closed'];

    public $translatable = ['title', 'body'];

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    protected static function booted()
    {
        static::updated(function ($alert) {
            ResponseCache::forget('/api/alert');
            ResponseCache::forget('/v1/alert');
        });
    }
}
