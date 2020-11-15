<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'shortName' => $this->short_name,
            'slug' => $this->slug,
            'defaultVehicleType' => $this->vehicles_type,
            'color' => $this->color,
            'textColor' => $this->text_color,
            'regions' => RegionSimpleResource::collection($this->regions),
            'license' => [
                'url' => $this->license['license_url'],
                'title' => $this->license['license_title'],
                'isDownloadable' => $this->license['is_downloadable'],
            ],
        ];
    }
}
