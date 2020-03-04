<?php

namespace App\Http\Resources;

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
            'conditions' => $this->conditions,
            'credits' => $this->credits,
            'info_body' => $this->info_body,
            'info_title' => $this->info_title,
            'map' => $this->map,
            'map_box' => $this->map_box,
            'map_zoom' => $this->map_zoom,
            'name' => $this->name,
            'slug' => $this->slug,
            'agencies' => AgencyResource::collection($this->activeAgencies)
        ];
    }
}
