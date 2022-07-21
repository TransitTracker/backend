<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    protected $fillable = ['agency_id', 'route_id', 'short_name', 'long_name', 'color', 'text_color'];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}
