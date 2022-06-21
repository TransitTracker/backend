<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\NotificationUser>
 */
class NotificationUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'isActive' => $this->is_active,
            'isFrench' => $this->is_french,
            'uuid' => $this->uuid,
            'electricStm' => $this->subscribed_electric_stm,
            'generalNews' => $this->subscribed_general_news,
            'newVehicle' => [
                'agencies' => AgencySimpleResource::collection($this->agencies),
            ],
            'favoriteVehicles' => VehiclePushResource::collection($this->vehicles),
        ];
    }
}
