<?php

namespace App\Http\Resources\V2\VehiclesGeoJson;

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;
use App\Enums\VehicleType;
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
                    'scheduleRelationshipLabel' => $this->when($request->boolean('label'), ScheduleRelationship::coerce($this->schedule_relationship)?->description),
                    'blockId' => $this->trip?->gtfs_block_id,
                    'serviceId' => $this->trip?->gtfs_service_id,
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
                    'label' => $this->force_label ?? $this->label ?? $this->force_vehicle_id ?? $this->vehicle_id,
                    'licensePlate' => $this->license_plate,
                    'type' => $this->vehicle_type,
                    'typeLabel' => $this->when($request->boolean('label'), VehicleType::coerce($this->vehicle_type)?->description),
                ],
                'position' => [
                    'bearing' => $this->bearing,
                    'odometer' => $this->odometer,
                    'speed' => $this->speed,
                ],
                'agencyId' => $this->agency_id,
                'currentStopSequence' => $this->current_stop_sequence,
                // stop_id to add eventually
                'currentStatus' => $this->current_status,
                'currentStatusLabel' => $this->when($request->boolean('label'), VehicleStopStatus::coerce($this->current_status)?->description),
                'congestionLevel' => $this->congestion_level,
                'congestionLevelLabel' => $this->when($request->boolean('label'), CongestionLevel::coerce($this->congestion_level)?->description),
                'occupancyStatus' => $this->occupancy_status,
                'occupancyStatusLabel' => $this->when($request->boolean('label'), OccupancyStatus::coerce($this->occupancy_status)?->description),
                'firstSeenAt' => $this->created_at->getTimestamp(),
                'lastSeenAt' => $this->last_seen_at->getTimestamp(),
                'links' => $this->activeLinks->pluck('id'),
                'tags' => $this->tags->pluck('id'),
            ],
            'id' => $this->id,
        ];
    }
}
