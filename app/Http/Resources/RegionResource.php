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
            'conditions' => $this->getTranslations('conditions'),
            'credits' => $this->getTranslations('credits'),
            'info_body' => $this->getTranslations('info_body'),
            'info_title' => $this->getTranslations('info_title'),
            'map' => $this->map,
            'map_box' => $this->map_box,
            'map_zoom' => $this->map_zoom,
            'name' => $this->name,
            'slug' => $this->slug,
            'agencies' => AgencyResource::collection($this->activeAgencies),
        ];
    }
}
