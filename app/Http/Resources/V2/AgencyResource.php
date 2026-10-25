<?php

namespace App\Http\Resources\V2;

use App\Models\Agency;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Agency>
 *
 * @mixin Agency
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
            'defaultVehicleType' => strtolower($this->default_vehicle_type?->key ?? 'bus'),
            'vehicleTypes' => collect($this->vehicle_types ?? [])->map(fn ($type) => (int) $type)->values()->all(),
            'color' => $this->color,
            'textColor' => $this->text_color,
            'regions' => $this->regions->pluck('slug'),
            'license' => [
                'url' => array_key_exists('license_url', $this->license) ? $this->license['license_url'] : null,
                'title' => array_key_exists('license_title', $this->license) ? $this->license['license_title'] : null,
                'isDownloadable' => array_key_exists('is_downloadable', $this->license) ? boolval($this->license['is_downloadable']) : null,
            ],
            'features' => $this->features ?? [],
            'meta' => (object) [],
        ];
    }
}
