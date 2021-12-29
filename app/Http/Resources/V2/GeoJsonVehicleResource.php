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
        $icon = ($this->agency->slug === 'stm' && $this->vehicle === '39037') ? 'habs' : $this->icon;

        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $this->id,
                'label' => $this->label ? $this->label : $this->vehicle,
                'marker-symbol' => "tt-{$this->agency->slug}-{$icon}",
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$this->lon, $this->lat],
            ],
        ];
    }
}
