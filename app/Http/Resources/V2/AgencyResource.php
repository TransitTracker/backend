<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<\App\Models\Agency>
 */
class AgencyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isArchived' => $this->is_archived,
            'name' => $this->name,
            'shortName' => $this->short_name,
            'slug' => $this->slug,
            'cities' => $this->random_cities,
            'defaultVehicleType' => $this->vehicles_type,
            'color' => $this->color,
            'textColor' => $this->text_color,
            'regions' => RegionSimpleResource::collection($this->regions),
            'license' => [
                'url' => array_key_exists('license_url', $this->license) ? $this->license['license_url'] : null,
                'title' => array_key_exists('license_title', $this->license) ? $this->license['license_title'] : null,
                'isDownloadable' => array_key_exists('is_downloadable', $this->license) ? boolval($this->license['is_downloadable']) : null,
            ],
            'meta' => (object) [],
        ];
    }
}
