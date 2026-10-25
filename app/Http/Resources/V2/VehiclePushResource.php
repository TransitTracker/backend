<?php

namespace App\Http\Resources\V2;

use App\Models\Vehicle;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @extends JsonResource<Vehicle>
 *
 * @mixin Vehicle
 */
class VehiclePushResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'agencyId' => $this->agency_id,
            'vehicleType' => $this->vehicle_type,
            'label' => $this->displayed_label,
            'lastSeenAt' => $this->last_seen_at->getTimestamp(),
        ];
    }
}
