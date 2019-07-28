<?php

namespace App\Http\Resources;

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
            // TODO: Change vehicle to ref
            'ref' => $this->vehicle,
            'agency_id' => $this->agency_id,
            'gtfs_trip' => $this->gtfs_trip,
            'route' => $this->route,
            'start' => $this->start,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'bearing' => $this->bearing,
            'speed' => $this->speed,
            'stop_sequence' => $this->stop_sequence,
            'status' => $this->status,
            'trip' => new TripResource($this->trip)
        ];
    }
}
