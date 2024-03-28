<?php

namespace App\Http\Resources\V2\VehiclesGeoJson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehiclesCollection extends ResourceCollection
{
    public static $wrap = 'features';

    public function toArray(Request $request): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => VehicleResource::collection($this->collection),
        ];
    }
}
