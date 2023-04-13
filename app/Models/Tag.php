<?php

namespace App\Models;

use App\Enums\TagType;
use App\Events\TagCreated;
use App\Events\TagUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['label', 'short_label', 'description'];

    protected $casts = [
        'type' => TagType::class,
    ];

    public function agencies(): MorphToMany
    {
        return $this->morphedByMany(Agency::class, 'taggable');
    }

    public function vehicles(): MorphToMany
    {
        return $this->morphedByMany(Vehicle::class, 'taggable');
    }

    public function scopeOfType(Builder $query, int $type): Builder
    {
        return $query->where('type', $type);
    }

    /*
     * Events
     */
    protected $dispatchesEvents = [
        'created' => TagCreated::class,
        'updated' => TagUpdated::class,
    ];
}
