<?php

namespace App\Http\Resources\V2;

use App\Models\CarriageType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<CarriageType>
 *
 * @mixin CarriageType
 */
class CarriageTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->carriage_category,
            'make' => $this->make,
            'model' => $this->model,
        ];
    }
}
