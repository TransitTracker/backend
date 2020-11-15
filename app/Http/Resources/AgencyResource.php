<?php

namespace App\Http\Resources;

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
            'color' => $this->color,
            'text_color' => $this->text_color,
            'vehicles_type' => $this->vehicles_type,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'region' => $this->regions[0]->slug,
            'license' => $this->license,
        ];
    }
}
