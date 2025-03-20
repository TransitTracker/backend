<?php

namespace App\Http\Resources\V2;

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Vehicle>
 */
class VehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            'isActive' => $this->is_active,
            'label' => $this->displayed_label,
            'timestamp' => $this->timestamp,
            // Do not display trip_id for STL since it's not accurate
            'tripId' => $this->agency->slug !== 'stl' ? $this->gtfs_trip_id : null,
            'routeId' => $this->gtfs_route_id,
            'startTime' => $this->start_time,
            'position' => [
                'lat' => $this->position?->latitude,
                'lon' => $this->position?->longitude,
            ],
            'bearing' => $this->bearing,
            'speed' => $this->speed,
            'vehicleType' => strtolower($this->vehicle_type?->key),
            'plate' => $this->license_plate,
            'odometer' => $this->odometer,
            'currentStopSequence' => $this->current_stop_sequence,
            'currentStatus' => [
                'data' => $this->current_status,
                'label' => VehicleStopStatus::coerce($this->current_status)?->description,
            ],
            'scheduleRelationship' => [
                'data' => $this->schedule_relationship,
                'label' => ScheduleRelationship::coerce($this->schedule_relationship)?->description,
            ],
            'congestionLevel' => [
                'data' => $this->congestion_level,
                'label' => CongestionLevel::coerce($this->congestion_level)?->description,
            ],
            'occupancyStatus' => [
                'data' => $this->occupancy_status,
                'label' => OccupancyStatus::coerce($this->occupancy_status)?->description,
            ],
            'agency' => $this->agency->slug,
            'links' => $this->activeLinks->pluck('id')->unique()->sort()->values()->all(),
            'tags' => TagSimpleResource::collection($this->tags),
            'trip' => TripResource::make($this)->additional(['agencySlug' => $this->agency->slug]),
            'createdAt' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'meta' => (object) [],
            $this->mergeWhen($request->has('include'), [
                'updatedAt' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
                'agencyName' => $this->agency->name,
            ]),
        ];
    }
}
