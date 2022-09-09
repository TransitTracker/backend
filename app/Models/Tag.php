<?php

namespace App\Models;

use App\Events\TagCreated;
use App\Events\TagUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['label', 'short_label', 'icon', 'color', 'dark_color', 'text_color', 'dark_text_color', 'show_on_map'];

    public $translatable = ['label', 'short_label'];

    public function agencies(): MorphToMany
    {
        return $this->morphedByMany(Agency::class, 'taggable');
    }

    public function vehicles(): MorphToMany
    {
        return $this->morphedByMany(Vehicle::class, 'taggable');
    }

    /*
     * Events
     */
    protected $dispatchesEvents = [
        'created' => TagCreated::class,
        'updated' => TagUpdated::class,
    ];
}
