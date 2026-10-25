<?php

namespace App\Http\Resources\V2;

use App\Models\Agency;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Agency>
 *
 * @mixin Agency
 */
class AgencySimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->slug;
    }
}
