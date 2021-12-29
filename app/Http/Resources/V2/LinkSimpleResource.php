<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Link>
 */
class LinkSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->id;
    }
}
