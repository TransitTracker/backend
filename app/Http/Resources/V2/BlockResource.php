<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->gtfs_trip_id,
            'headsign' => $this->headsign,
            'shortName' => $this->short_name,
            'routeColor' => $this->route_color,
            'routeTextColor' => $this->route_text_color,
            'routeShortName' => $this->route_short_name,
            'departure' => $this->firstDeparture->departure,
        ];
    }
}
