<?php

namespace App\Models;

use Arr;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Region.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array|null $info_title
 * @property array|null $info_body
 * @property array $map_box
 * @property AsArrayObject $map_center
 * @property int $map_zoom
 * @property array $credits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array $description
 * @property array|null $meta_description
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $activeAgencies
 * @property-read int|null $active_agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alert[] $activeAlerts
 * @property-read int|null $active_alerts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alert[] $alerts
 * @property-read int|null $alerts_count
 * @property-read array $cities
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stat[] $stats
 * @property-read int|null $stats_count
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereInfoBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereInfoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapZoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Region extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'info_title', 'info_body', 'map_box', 'map_center', 'map_zoom', 'credits', 'description', 'meta_description', 'image'];

    protected $casts = [
        'map_box' => 'array',
        'map_center' => AsArrayObject::class,
        'map_zoom' => 'integer',
    ];

    public $translatable = ['info_title', 'info_body', 'credits', 'description', 'meta_description'];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function activeAgencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class)->active();
    }

    public function alerts(): BelongsToMany
    {
        return $this->belongsToMany(Alert::class);
    }

    public function activeAlerts(): BelongsToMany
    {
        return $this->belongsToMany(Alert::class)->active();
    }

    /**
     * @return Builder<Vehicle>
     */
    public function vehicles()
    {
        return Vehicle::active()->whereIn('agency_id', $this->activeAgencies->modelKeys());
    }

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class);
    }

    public function getCitiesAttribute(): array
    {
        return Cache::remember("tt-region-{$this->slug}-cities", 60 * 60 * 24 * 7, function () {
            $allCities = [];
            foreach ($this->activeAgencies as $agency) {
                array_push($allCities, Arr::random($agency->cities));
            }

            return $allCities;
        });
    }

    protected static function booted()
    {
        static::updated(function (self $region) {
            ResponseCache::forget('/api/regions');
            ResponseCache::forget('/v1/regions');

            ResponseCache::selectCachedItems()
                ->usingSuffix('en')
                ->forUrls('/v2/landing', '/v2/regions', "/v2/regions/{$region->slug}", "/v2/regions/{$region->slug}/alerts")
                ->forget();
            ResponseCache::selectCachedItems()
                ->usingSuffix('fr')
                ->forUrls('/v2/landing', '/v2/regions', "/v2/regions/{$region->slug}", "/v2/regions/{$region->slug}/alerts")
                ->forget();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
