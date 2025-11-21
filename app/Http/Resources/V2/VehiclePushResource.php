<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiclePushResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
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
