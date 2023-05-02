<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class GeoJsonLandingVehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'Feature',
            'geometry' => $this->position,
        ];
    }
}
