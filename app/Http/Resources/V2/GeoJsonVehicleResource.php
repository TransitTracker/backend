<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Vehicle>
 */
class GeoJsonVehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $this->id,
                'label' => $this->displayed_label,
                'marker-symbol' => "tt-{$this->agency->slug}-{$this->vehicle_type}",
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => $this->position,
            ],
        ];
    }
}
