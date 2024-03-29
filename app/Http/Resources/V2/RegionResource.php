<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Region>
 */
class RegionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'credits' => $this->credits,
            'infoTitle' => '',
            'infoBody' => '',
            'description' => $this->description,
            'metaDescription' => $this->meta_description,
            'cities' => $this->cities,
            'image' => basename($this->image),
            'mapBox' => $this->map_box,
            'mapCenter' => $this->map_center,
            'mapZoom' => $this->map_zoom,
            'agencies' => AgencyResource::collection($this->activeAgencies),
        ];
    }
}
