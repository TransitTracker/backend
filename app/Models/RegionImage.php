<?php

namespace App\Models;

use App\Enums\RegionImageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionImage extends Model
{
    protected $fillable = [
        'region_id',
        'image_path',
        'author_name',
        'author_email',
        'author_link',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => RegionImageStatus::class,
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
