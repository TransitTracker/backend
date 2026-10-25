<?php

namespace App\Http\Resources\V2;

use App\Models\Gtfs\StopTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<StopTime>
 *
 * @mixin StopTime
 */
class GeoJsonShapeStopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Feature',
            'properties' => (object) [],
            'geometry' => $this->stop->position,
        ];
    }
}
