<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Region>
 */
class GeoJsonLandingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'Feature',
            'properties' => [
                'slug' => $this->slug,
                'name' => $this->name,
                'agencies' => $this->active_agencies_count,
                'vehicles' => $this->vehicles()->count(),
                'cities' => $this->cities,
                'range' => 15 - $this->map_zoom,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    $this->map_center['lon'],
                    $this->map_center['lat'],
                ],
            ],
        ];
    }
}
