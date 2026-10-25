<?php

namespace App\Http\Resources\V2;

use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Vehicle>
 *
 * @mixin Vehicle
 */
class GeoJsonVehicleResource extends JsonResource
{
    public function toArray($request)
    {
        $vehicleType = strtolower($this->vehicle_type?->key);

        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $this->id,
                'label' => $this->displayed_label,
                'marker-symbol' => "tt-{$this->agency->slug}-{$vehicleType}",
            ],
            'geometry' => $this->position,
        ];
    }
}
