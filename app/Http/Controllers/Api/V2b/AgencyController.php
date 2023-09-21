<?php

namespace App\Http\Controllers\Api\V2b;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2b\GeoJson\VehiclesCollection;
use App\Models\Agency;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Agency $agency)
    {
        //
    }

    public function vehicles(string $agency, Request $request)
    {
        $agency = Agency::query()
            ->where('slug', $agency)
            ->select(['id', 'timestamp'])
            ->firstOrFail();

        $vehicles = Vehicle::query()
            ->whereBelongsTo($agency)
            ->active()
            ->select([
                'id', 'position', 'gtfs_trip_id', 'start_time', 'schedule_relationship', 'gtfs_route_id', 'force_vehicle_id', 'vehicle_id', 'force_label', 'label', 'license_plate', 'vehicle_type', 'bearing', 'odometer', 'speed', 'current_stop_sequence', 'current_status', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at'
            ])
            ->with([
                'trip:agency_id,gtfs_trip_id,short_name,headsign,gtfs_block_id,gtfs_shape_id',
                'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color',
                'links:id',
                'tags:id',
            ])
            ->get();

        return VehiclesCollection::make($vehicles)
            ->additional([
                'lastRefreshAt' => $agency->timestamp,
            ]);
    }
}
