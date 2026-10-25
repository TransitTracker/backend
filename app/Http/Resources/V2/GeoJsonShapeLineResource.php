<?php

namespace App\Http\Resources\V2;

use App\Models\Gtfs\Shape;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<Shape>
 *
 * @mixin Shape
 */
class GeoJsonShapeLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Feature',
            'properties' => (object) [],
            'geometry' => $this->shape,
        ];
    }
}
