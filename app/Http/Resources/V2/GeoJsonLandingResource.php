<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class GeoJsonLandingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
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
