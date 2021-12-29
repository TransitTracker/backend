<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

/*
 * @extends JsonResource<\App\Models\Vehicle>
 */
class GeoJsonVehiclesCollection extends ResourceCollection
{
    public static $wrap = 'features';

    public function toArray($request)
    {
        return [
            'type' => 'FeatureCollection',
            'features' => GeoJsonVehicleResource::collection($this->collection),
        ];
    }
}
