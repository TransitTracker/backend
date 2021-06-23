<?php

namespace App\Http\Resources\V2;

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ref' => $this->vehicle,
            'isActive' => $this->active,
            'label' => $this->force_label ?? $this->label ?? $this->vehicle,
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
            'trip' => TripResource::make($this->trip)->additional(['agencySlug' => $this->agency->slug]),
            'meta' => $this->when($this->agency->slug === 'stm' && $this->vehicle === '39037', (object) ['habsBus' => true], (object) []),
            $this->mergeWhen($request->include && $request->include === 'all', [
                'updatedAt' => Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
                'createdAt' => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
            ]),
        ];
    }
}
