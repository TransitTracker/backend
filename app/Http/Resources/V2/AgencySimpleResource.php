<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class AgencySimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->slug;
    }
}
