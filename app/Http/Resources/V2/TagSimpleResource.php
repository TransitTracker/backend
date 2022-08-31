<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class TagSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->id;
    }
}
