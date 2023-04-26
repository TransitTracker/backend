<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
