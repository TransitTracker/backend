<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'credits' => $this->credits,
            'infoTitle' => $this->info_title,
            'infoBody' => $this->info_body,
            'description' => $this->description,
            'mapCenter' => [
                'lat' => $this->map_box[0],
                'lon' => $this->map_box[1],
            ],
            'mapZoom' => $this->map_zoom,
            'agencies' => AgencyResource::collection($this->agencies),
        ];
    }
}
