<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\VehicleResource;
use App\Http\Resources\V2\VehiclesGeoJson\VehiclesCollection;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;

#[Group('Vehicles')]
class VehicleController extends Controller
{
    public function __construct()
    {
        $vehiclesChunk = (Vehicle::count() / 500) + 5;

        if (! App::environment('local')) {
            $this->middleware('throttle:30,1,v2-vehicles')->except('index');
            $this->middleware("throttle:{$vehiclesChunk},1,v2-vehicles")->only('index');
        }

        $this->middleware('cacheResponse:300');
    }

    public function index(Request $request)
    {
        $this->middleware('cacheResponse:900');

        $request->merge(['include' => 'all']);

        $vehicles = Vehicle::query()
            ->downloadable()
            ->select(['id', 'vehicle_id', 'force_vehicle_id', 'is_active', 'label', 'force_label', 'timestamp', 'gtfs_trip_id', 'gtfs_route_id', 'start_time', 'position', 'bearing', 'speed', 'vehicle_type', 'license_plate', 'current_stop_sequence', 'current_status', 'schedule_relationship', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'updated_at'])
            ->with(['trip:agency_id,gtfs_trip_id,headsign,short_name,gtfs_block_id,gtfs_service_id,gtfs_shape_id', 'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color', 'activeLinks:id', 'agency:id,slug,name,features', 'tags:id'])
            ->paginate(500);

        return VehicleResource::collection($vehicles);
    }

    public function indexGeoJson(Request $request)
    {
        $this->middleware('cacheResponse:900');
        $vehicles = Vehicle::query()
            ->downloadable()
            ->select([
                'id', 'position', 'gtfs_trip_id', 'start_time', 'schedule_relationship', 'gtfs_route_id', 'force_vehicle_id', 'vehicle_id', 'force_label', 'label', 'license_plate', 'vehicle_type', 'bearing', 'odometer', 'speed', 'current_stop_sequence', 'current_status', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'last_seen_at',
            ])
            ->with([
                'trip:agency_id,gtfs_trip_id,short_name,headsign,gtfs_block_id,gtfs_shape_id',
                'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color',
                'activeLinks:id',
                'tags:id',
            ]);

        if (! $request->boolean('history')) {
            $vehicles->active();
        }

        return VehiclesCollection::make($vehicles->paginate(250))->preserveQuery();
    }

    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }
}
