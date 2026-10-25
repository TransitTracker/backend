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
class GeoJsonShapeResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => [
                GeoJsonShapeLineResource::make($this),
                ...GeoJsonShapeStopResource::collection($this->firstTrip->stopTimes),
            ],
        ];
    }
}
