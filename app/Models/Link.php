<?php

namespace App\Models;

use App\Models\Vehicle;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Link extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $fillable = ['internal_title', 'title', 'description', 'link'];

    protected $translatable = ['title', 'description'];

    public function agencies()
    {
        return $this->belongsToMany(Agency::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }

    protected static function booted()
    {
        static::updated(function ($link) {
            ResponseCache::forget('/api/links');
        });
    }
}
