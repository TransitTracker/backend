<?php

namespace App\Http\Resources\V2;

use App\Models\Region;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Region>
 *
 * @mixin Region
 */
class RegionSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->slug;
    }
}
