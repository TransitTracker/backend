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
            'isActive' => $this->active,
            'label' => $this->displayed_label,
            'timestamp' => $this->timestamp,
            'tripId' => $this->gtfs_trip,
            'routeId' => $this->route,
            'startTime' => $this->start,
            'position' => [
                'lat' => $this->lat,
                'lon' => $this->lon,
            ],
            'bearing' => $this->bearing,
            'speed' => $this->speed,
            'vehicleType' => $this->icon,
            'plate' => $this->plate,
            'odometer' => $this->odometer,
            'currentStopSequence' => $this->stop_sequence,
            'currentStatus' => [
                'data' => $this->status,
                'label' => filled($this->status) ? VehicleStopStatus::getDescription($this->status) : null,
            ],
            'scheduleRelationship' => [
                'data' => $this->relationship,
                'label' => filled($this->relationship) ? ScheduleRelationship::getDescription($this->relationship) : null,
            ],
            'congestionLevel' => [
                'data' => $this->congestion,
                'label' => filled($this->congestion) ? CongestionLevel::getDescription($this->congestion) : null,
            ],
            'occupancyStatus' => [
                'data' => $this->occupancy,
                'label' => filled($this->occupancy) ? OccupancyStatus::getDescription($this->occupancy) : null,
            ],
            'agency' => $this->agency->slug,
            'links' => LinkSimpleResource::collection($this->links),
            'tags' => TagSimpleResource::collection($this->tags),
            'trip' => TripResource::make($this->trip)->additional(['agencySlug' => $this->agency->slug]),
            'createdAt' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'meta' => (object) [],
            $this->mergeWhen($request->has('include'), [
                'updatedAt' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
                'agencyName' => $this->agency->name,
            ]),
        ];
    }
}
