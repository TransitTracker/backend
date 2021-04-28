<?php

namespace App\Http\Resources;

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;
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
            'agency_id' => $this->agency_id,
            'gtfs_trip' => $this->gtfs_trip,
            'route' => $this->route,
            'start' => $this->start,
            'relationship' => ScheduleRelationship::getDescription($this->relationship),
            'label' => $this->force_label ?? $this->label,
            'plate' => $this->plate,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'bearing' => $this->bearing,
            'odometer' => $this->odometer,
            'speed' => $this->speed,
            'stop_sequence' => $this->stop_sequence,
            'status' => VehicleStopStatus::getDescription($this->status),
            'timestamp' => $this->timestamp,
            'congestion' => CongestionLevel::getDescription($this->congestion),
            'occupancy' => OccupancyStatus::getDescription($this->occupancy),
            'trip' => new TripResource($this->trip),
            'icon' => $this->icon,
            'links' => VehicleLinkResource::collection($this->links),
        ];
    }
}
