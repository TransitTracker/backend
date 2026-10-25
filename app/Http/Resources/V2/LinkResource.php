<?php

namespace App\Http\Resources\V2;

use App\Models\Link;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Link>
 *
 * @mixin Link
 */
class LinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->link,
        ];
    }
}
