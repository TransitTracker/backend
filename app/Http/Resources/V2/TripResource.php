<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'shortName' => $this->trip_short_name,
            'routeColor' => $this->route_color,
            'routeTextColor' => $this->route_text_color,
            'routeShortName' => $this->route_short_name,
            'routeLongName' => $this->route_long_name,
            'shapeLink' => $this->shape ? Storage::url("shapes/{$this->additional['agencySlug']}/{$this->shape}.json") : null,
            'serviceId' => $this->service->service_id,
        ];
    }
}
