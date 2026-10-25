<?php

namespace App\Http\Resources\V2;

use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Tag>
 *
 * @mixin Tag
 */
class TagSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->id;
    }
}
