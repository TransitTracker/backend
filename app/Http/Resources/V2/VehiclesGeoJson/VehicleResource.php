<?php

namespace App\Http\Resources\V2\VehiclesGeoJson;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Vehicle>
 */
class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Feature',
            'geometry' => $this->position,
            'properties' => [
                'trip' => [
                    'id' => $this->gtfs_trip_id,
                    'shortName' => $this->trip?->short_name,
                    'headsign' => $this->trip?->headsign,
                    'startTime' => $this->start_time,
                    'scheduleRelationship' => $this->schedule_relationship,
                    'blockId' => $this->trip?->gtfs_block_id,
                    'shapeId' => $this->trip?->gtfs_shape_id,
                ],
                'route' => [
                    'id' => $this->gtfs_route_id,
                    'shortName' => $this->gtfsRoute?->short_name,
                    'longName' => $this->gtfsRoute?->long_name,
                    'color' => $this->gtfsRoute?->color,
                    'textColor' => $this->gtfsRoute?->text_color,
                ],
                'vehicle' => [
                    'id' => $this->force_vehicle_id ?? $this->vehicle_id,
                    'label' => $this->force_label ?? $this->label,
                    'licensePlate' => $this->license_plate,
                    'type' => $this->vehicle_type,
                ],
                'position' => [
                    'bearing' => $this->bearing,
                    'odometer' => $this->odometer,
                    'speed' => $this->speed,
                ],
                'currentStopSequence' => $this->current_stop_sequence,
                // stop_id to add eventually
                'currentStatus' => $this->current_status,
                'congestionLevel' => $this->congestion_level,
                'occupancyStatus' => $this->occupancy_status,
                'firstSeenAt' => Carbon::parse($this->created_at)->getTimestamp(),
                'lastSeenAt' => Carbon::parse($this->last_seen_at)->getTimestamp(),
                'links' => $this->links->pluck('id'),
                'tags' => $this->tags->pluck('id'),
            ],
            'id' => $this->id,
        ];
    }
}
