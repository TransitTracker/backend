<?php

namespace App\Http\Resources\V2;

use App\Models\Link;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Link>
 *
 * @mixin Link
 */
class LinkSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->id;
    }
}
