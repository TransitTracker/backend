<?php

namespace App\Http\Resources\V2;

use App\Models\NotificationUser;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<NotificationUser>
 *
 * @mixin NotificationUser
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
            'favoriteVehiclesCount' => $this->vehicles_count,
        ];
    }
}
