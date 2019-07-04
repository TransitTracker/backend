<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'id' => $this->trip_id,
            'headsign' => $this->trip_headsign,
            'trip_short_name' => $this->trip_short_name,
            'color' => $this->route_color,
            'text_color' => $this->route_text_color,
            'route_short_name' => $this->route_short_name,
            'long_name' => $this->route_long_name,
        ];
    }
}
