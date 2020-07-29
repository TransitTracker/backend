<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeojsonVehicleResource extends JsonResource
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
            'properties' => (object) [
                'id' => $this->id,
                'label' => $this->label,
                'marker-symbol' => $this->icon,
            ],
            'geometry' => (object) [
                'type' => 'Point',
                'coordinates' => [$this->lon, $this->lat],
            ],
        ];
    }
}
