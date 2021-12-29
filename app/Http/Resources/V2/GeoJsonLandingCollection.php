<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GeoJsonLandingCollection extends ResourceCollection
{
    public static $wrap = 'features';

    public function toArray($request)
    {
        return [
            'type' => 'FeatureCollection',
            'features' => GeoJsonLandingResource::collection($this->collection),
        ];
    }
}
