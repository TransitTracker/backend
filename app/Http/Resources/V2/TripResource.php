<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/* @extends JsonResource<\App\Models\Vehicle> */
class TripResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->trip?->gtfs_trip_id,
            'headsign' => $this->trip?->headsign,
            'shortName' => $this->trip?->short_name,
            'routeColor' => $this->gtfsRoute?->color,
            'routeTextColor' => $this->gtfsRoute?->text_color,
            'routeShortName' => $this->gtfsRoute?->short_name,
            'routeLongName' => $this->gtfsRoute?->long_name,
            'shapeLink' => $this->trip?->gtfs_shape_id ? Storage::url("shapes/{$this->additional['agencySlug']}/{$this->trip?->gtfs_shape_id}.json") : null,
            'shapeId' => $this->trip?->gtfs_shape_id,
            'serviceId' => $this->trip?->gtfs_shape_id,
            'blockId' => $this->trip?->gtfs_block_id,
        ];
    }
}
