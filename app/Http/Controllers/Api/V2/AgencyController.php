<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AgencyResource;
use App\Http\Resources\V2\GeoJsonVehiclesCollection;
use App\Http\Resources\V2\VehicleResource;
use App\Http\Resources\V2\VehiclesGeoJson\VehiclesCollection;
use App\Models\Agency;
use App\Models\Vehicle;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;
use function Illuminate\Support\minutes;

#[Group('Agencies')]
class AgencyController extends Controller
{
    public function __construct()
    {
        if (! App::environment('local', 'testing')) {
            $totalAgencies = 3 * Agency::active()->count();
            $this->middleware("throttle:{$totalAgencies},1,v2-agencies");
        }

        $this->middleware(CacheResponse::for(days(7), tags: ['agencies']))->except(['vehicles', 'vehiclesGeoJson']);
        $this->middleware(CacheResponse::for(minutes(5)))->only(['vehicles', 'vehiclesGeoJson']);
    }

    /**
     * List all active agencies
     *
     * Retrieve a list of all active transit agencies currently supported by Transit Tracker.
     */
    public function index()
    {
        $agencies = Agency::query()
            ->active()
            ->select(['id', 'name', 'short_name', 'slug', 'cities', 'default_vehicle_type', 'vehicle_types', 'color', 'text_color', 'license', 'is_archived', 'features'])
            ->with(['regions' => function ($query) {
                $query->select('slug')->orderBy('order_id');
            }])
            ->orderBy('order_id')
            ->get();

        return AgencyResource::collection($agencies);
    }

    /**
     * Get agency details
     *
     * Retrieve detailed metadata and supported features for a specific transit agency by its slug.
     */
    #[PathParameter('agency', description: 'The unique slug identifier of the transit agency (e.g., `stm`, `exo`, `rtl`).', type: 'string', example: 'stm')]
    public function show(Agency $agency)
    {
        $agency->load('regions:slug');

        // If it's inactive and there is no user logged in, do not show
        if (! $agency->is_active && ! Auth::check()) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        return AgencyResource::make($agency);
    }

    /**
     * Get vehicles for an agency
     *
     * @deprecated This route will be removed in the future. Use the GeoJSON equivalent instead.
     *
     * Retrieve real-time vehicle positions and operational status for an agency, with optional GeoJSON FeatureCollection metadata.
     */
    #[Group('Vehicles')]
    #[PathParameter('agency', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'stm')]
    #[QueryParameter('geojson', description: 'Include a GeoJSON FeatureCollection in the response metadata (`additional.geojson`). Defaults to true.', type: 'bool', default: true, example: true)]
    #[QueryParameter('include', description: 'Pass `all` to include inactive downloadable vehicles with pagination (100 per page). Defaults to only active vehicles.', type: 'string', example: 'all')]
    public function vehicles(Request $request, Agency $agency)
    {
        if (! $agency->is_active && ! Auth::check()) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        $includeAll = $request->input('include', null) === 'all';
        $includeGeoJson = $request->input('geojson', null) !== 'false';

        $query = Vehicle::query()
            ->where('agency_id', $agency->id)
            ->select(['id', 'vehicle_id', 'force_vehicle_id', 'is_active', 'label', 'force_label', 'timestamp', 'gtfs_trip_id', 'gtfs_route_id', 'start_time', 'position', 'bearing', 'speed', 'vehicle_type', 'license_plate', 'current_stop_sequence', 'current_status', 'schedule_relationship', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'updated_at'])
            ->with(['trip:agency_id,gtfs_trip_id,headsign,short_name,gtfs_block_id,gtfs_service_id,gtfs_shape_id', 'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color', 'activeLinks:id', 'agency:id,slug,name,features', 'tags:id']);

        if (! $includeAll) {
            $query->where('is_active', true);

            $vehicles = $query->get();
        } else {
            $query->downloadable();

            $vehicles = $query->paginate(100);
        }

        $additional = [
            'timestamp' => $agency->timestamp,
            'count' => count($vehicles),
        ];

        if ($includeGeoJson) {
            $additional['geojson'] = GeoJsonVehiclesCollection::make($vehicles);
        }

        return VehicleResource::collection($vehicles)->additional($additional)->preserveQuery();
    }

    /**
     * @deprecated This route will be removed in the future. Use the GeoJSON equivalent instead.
     * Get single vehicle for an agency
     *
     * Retrieve a specific vehicle by its vehicle identifier reference or custom ID.
     */
    #[Group('Vehicles')]
    #[PathParameter('agency', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'stm')]
    #[PathParameter('vehicleRef', description: 'The vehicle identifier or force vehicle ID reference.', type: 'string', example: '40-001')]
    public function vehiclesShow(Agency $agency, string $vehicleRef)
    {
        $vehicle = Vehicle::query()
            ->where(['agency_id' => $agency->id, 'vehicle_id' => $vehicleRef, 'force_vehicle_id' => null])
            ->orWhere(function (Builder $query) use ($agency, $vehicleRef) {
                $query->where(['agency_id' => $agency->id, 'force_vehicle_id' => $vehicleRef]);
            })
            ->select(['id', 'vehicle_id', 'force_vehicle_id', 'is_active', 'label', 'force_label', 'timestamp', 'gtfs_trip_id', 'gtfs_route_id', 'start_time', 'position', 'bearing', 'speed', 'vehicle_type', 'license_plate', 'current_stop_sequence', 'current_status', 'schedule_relationship', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'updated_at'])
            ->with(['trip:agency_id,gtfs_trip_id,headsign,short_name,gtfs_block_id,gtfs_service_id,gtfs_shape_id', 'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color', 'activeLinks:id', 'agency:id,slug,name', 'tags:id'])
            ->firstOrFail();

        return VehicleResource::make($vehicle);
    }

    /**
     * Get single vehicle for an agency as GeoJSON
     *
     * Retrieve a specific vehicle formatted as an individual GeoJSON Feature.
     */
    #[Group('Vehicles')]
    #[PathParameter('agency', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'stm')]
    #[PathParameter('vehicleRef', description: 'The vehicle identifier or force vehicle ID reference.', type: 'string', example: '40-001')]
    public function vehiclesGeoJsonShow(Agency $agency, string $vehicleRef)
    {
        $vehicle = Vehicle::query()
            ->where(['agency_id' => $agency->id, 'vehicle_id' => $vehicleRef, 'force_vehicle_id' => null])
            ->orWhere(function (Builder $query) use ($agency, $vehicleRef) {
                $query->where(['agency_id' => $agency->id, 'force_vehicle_id' => $vehicleRef]);
            })
            ->select(['id', 'is_active', 'position', 'gtfs_trip_id', 'start_time', 'schedule_relationship', 'gtfs_route_id', 'force_vehicle_id', 'vehicle_id', 'force_label', 'label', 'license_plate', 'vehicle_type', 'bearing', 'odometer', 'speed', 'current_stop_sequence', 'current_status', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'last_seen_at'])
            ->with([
                'trip:agency_id,gtfs_trip_id,short_name,headsign,gtfs_block_id,gtfs_service_id,gtfs_shape_id',
                'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color',
                'carriages' => function (HasMany $query) {
                    $query->select(['agency_id', 'vehicle_id', 'carriage_id', 'label', 'occupancy_status', 'sequence', 'carriage_type_id'])->orderBy('sequence');
                },
                'activeLinks:id',
                'tags:id',
            ])
            ->firstOrFail();

        return \App\Http\Resources\V2\VehiclesGeoJson\VehicleResource::make($vehicle);
    }

    /**
     * Get vehicles for an agency as GeoJSON
     *
     * Retrieve all vehicles for a transit agency formatted as a GeoJSON FeatureCollection.
     */
    #[Group('Vehicles')]
    #[PathParameter('agency', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'stm')]
    #[QueryParameter('history', description: 'When true, includes historical/inactive vehicles and paginates by 500. When false, returns only active vehicles.', type: 'bool', default: false, example: false)]
    #[QueryParameter('label', description: 'When true, includes link titles and tag short labels in vehicle properties.', type: 'bool', default: false, example: false)]
    public function vehiclesGeoJson(string $agency, Request $request)
    {
        $agency = Agency::query()
            ->where('slug', $agency)
            ->select(['id', 'timestamp'])
            ->firstOrFail();

        $vehicles = Vehicle::query()
            ->whereBelongsTo($agency)
            ->select([
                'id', 'position', 'gtfs_trip_id', 'start_time', 'schedule_relationship', 'gtfs_route_id', 'force_vehicle_id', 'vehicle_id', 'force_label', 'label', 'license_plate', 'vehicle_type', 'bearing', 'odometer', 'speed', 'current_stop_sequence', 'current_status', 'congestion_level', 'occupancy_status', 'agency_id', 'created_at', 'last_seen_at',
            ])
            ->with([
                'trip:agency_id,gtfs_trip_id,short_name,headsign,gtfs_block_id,gtfs_service_id,gtfs_shape_id',
                'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name,color,text_color',
                'carriages' => function (HasMany $query) {
                    $query->select(['agency_id', 'vehicle_id', 'carriage_id', 'label', 'occupancy_status', 'sequence', 'carriage_type_id'])->orderBy('sequence');
                },
            ]);

        // When downloading data, add internal title and short label to download
        if ($request->boolean('label')) {
            $vehicles->with([
                'activeLinks:id,internal_title',
                'tags:id,short_label',
            ]);
        } else {
            $vehicles->with([
                'activeLinks:id',
                'tags:id',
            ]);
        }

        if ($request->boolean('history')) {
            $vehicles = $vehicles
                ->downloadable()
                ->paginate(500);
        } else {
            $vehicles = $vehicles
                ->active()
                ->get();
        }

        return VehiclesCollection::make($vehicles)
            ->additional([
                'lastRefreshAt' => $agency->timestamp,
            ])
            ->preserveQuery();
    }
}
