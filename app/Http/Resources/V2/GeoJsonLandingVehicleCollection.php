<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GeoJsonLandingVehicleCollection extends ResourceCollection
{
    public static $wrap = 'features';

    public function toArray($request): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => GeoJsonLandingVehicleResource::collection($this->collection),
        ];
    }
}
