<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\VehicleResource;
use App\Http\Resources\V2\VehiclesGeoJson\VehicleResource as GeoJsonVehicleResource;
use App\Http\Resources\V2\VehiclesGeoJson\VehiclesCollection;
use App\Models\Vehicle;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\minutes;

#[Group('Vehicles')]
class VehicleController extends Controller
{
    public function __construct()
    {
        if (! App::environment('local', 'testing')) {
            $vehiclesChunk = (Vehicle::count() / 500) + 5;
            $this->middleware('throttle:30,1,v2-vehicles')->except(['index', 'indexGeoJson']);
            $this->middleware("throttle:{$vehiclesChunk},1,v2-vehicles")->only(['index', 'indexGeoJson']);
        }

        $this->middleware(CacheResponse::for(minutes(5)));
    }

    /**
     * @deprecated This route will be removed in the future. Use the GeoJSON equivalent instead.
     * List all downloadable vehicles
     *
     * Retrieve a paginated list of all downloadable transit vehicles across all agencies (500 vehicles per page).
     */
    public function index(Request $request)
    {
        $request->merge(['include' => 'all']);

        $vehicles = Vehicle::query()
            ->downloadable()
            ->select(['id', 'vehicle_id', 'force_vehicle_id', 'is_active', 'label', 'force_label', 'timestamp', 'gtfs_trip_id', 'gtfs_route_id', 'start_time', 'position', 'bearing', 'speed', 'vehicle_type', 'license_plate', 'current_stop_sequence', 'current_status', 'schedule_relationship', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'updated_at'])
            ->with(['trip:agency_id,gtfs_trip_id,headsign,short_name,gtfs_block_id,gtfs_service_id,gtfs_shape_id', 'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color', 'activeLinks:id', 'agency:id,slug,name,features', 'tags:id'])
            ->paginate(500);

        return VehicleResource::collection($vehicles);
    }

    /**
     * List all vehicles as GeoJSON
     *
     * Retrieve a paginated GeoJSON FeatureCollection of transit vehicles across all agencies (500 vehicles per page).
     */
    #[QueryParameter('history', description: 'When true, includes historical/inactive vehicles. Defaults to active only.', type: 'bool', default: false, example: false)]
    public function indexGeoJson(Request $request)
    {
        $vehicles = Vehicle::query()
            ->downloadable()
            ->select([
                'id', 'position', 'gtfs_trip_id', 'start_time', 'schedule_relationship', 'gtfs_route_id', 'force_vehicle_id', 'vehicle_id', 'force_label', 'label', 'license_plate', 'vehicle_type', 'bearing', 'odometer', 'speed', 'current_stop_sequence', 'current_status', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'last_seen_at',
            ])
            ->with([
                'trip:agency_id,gtfs_trip_id,short_name,headsign,gtfs_block_id,gtfs_shape_id',
                'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color',
                'carriages:agency_id,vehicle_id,carriage_id,label,occupancy_status,sequence,carriage_type_id',
                'activeLinks:id,internal_title',
                'tags:id,short_label',
            ]);

        if (! $request->boolean('history')) {
            $vehicles->active();
        }

        return VehiclesCollection::make($vehicles->paginate(500))->preserveQuery();
    }

    /**
     * @deprecated This route will be removed in the future. Use the GeoJSON equivalent instead.
     * Get vehicle details by ID
     *
     * Retrieve complete details for a single transit vehicle by its internal database ID.
     */
    #[PathParameter('vehicle', description: 'Internal database ID of the vehicle.', type: 'int', example: 12345)]
    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }

    /**
     * Get vehicle as GeoJSON by ID
     *
     * Retrieve a single transit vehicle formatted as an individual GeoJSON Feature by its database ID.
     */
    #[PathParameter('vehicle', description: 'Internal database ID of the vehicle.', type: 'int', example: 12345)]
    public function showGeoJson(Vehicle $vehicle)
    {
        return GeoJsonVehicleResource::make($vehicle);
    }
}
