<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $guarded = [];

    protected $dateFormat = 'Ymd';

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
