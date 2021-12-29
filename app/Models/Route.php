<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Route
 *
 * @property int $id
 * @property string $agency_id
 * @property string $route_id
 * @property string $short_name
 * @property string $long_name
 * @property string $color
 * @property string $text_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency $agency
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Route extends Model
{
    protected $fillable = ['agency_id', 'route_id', 'short_name', 'long_name', 'color', 'text_color'];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}
