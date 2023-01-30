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
                'label' => VehicleStopStatus::getDescription($this->status),
            ],
            'scheduleRelationship' => [
                'data' => $this->relationship,
                'label' => ScheduleRelationship::getDescription($this->relationship),
            ],
            'congestionLevel' => [
                'data' => $this->congestion,
                'label' => CongestionLevel::getDescription($this->congestion),
            ],
            'occupancyStatus' => [
                'data' => $this->occupancy,
                'label' => OccupancyStatus::getDescription($this->occupancy),
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
