<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class GeoJsonVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
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
