<?php

namespace App\Http\Resources\V2;

use App\Enums\OccupancyStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarriageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->carriage_id,
            'label' => $this->label,
            'occupancyStatus' => $this->occupancy_status,
            'occupancyStatusLabel' => $this->when($request->boolean('label'), OccupancyStatus::coerce($this->occupancy_status)?->description),
            'type' => $this->carriage_type_id,
        ];
    }
}
