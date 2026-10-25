<?php

namespace App\Http\Resources\V2;

use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Vehicle>
 *
 * @mixin Vehicle
 */
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
