<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AgencyResource;
use App\Http\Resources\V2\GeoJsonVehiclesCollection;
use App\Http\Resources\V2\VehicleResource;
use App\Models\Agency;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Storage;

class AgencyController extends Controller
{
    public function __construct()
    {
        $totalAgencies = 3 * Agency::active()->count();

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalAgencies},1,v2-agencies");
        }

        $this->middleware('cacheResponse')->except('vehicles');
        $this->middleware('cacheResponse:300')->only('vehicles');
    }

    public function index()
    {
        $agencies = Agency::active()->with('regions:slug')->get();

        return AgencyResource::collection($agencies);
    }

    public function show(Request $request, Agency $agency)
    {
        // If it's inactive and there is no user logged in, do not show
        if (! $agency->is_active && ! $request->user('sanctum')) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        return AgencyResource::make($agency);
    }

    public function vehicles(Request $request, Agency $agency)
    {
        if (! $agency->is_active) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        $includeAll = $request->input('include', null) === 'all';
        $includeGeojson = $request->input('geojson', null) !== 'false';

        $vehicles = null;

        $query = Vehicle::query()
            ->where('agency_id', $agency->id)
            ->with(['trip', 'links:id', 'agency:id,slug,name', 'trip.service:id,service_id', 'tags:id']);

        if (! $includeAll) {
            $query->where('active', true);

            $vehicles = $query->get();
        } else {
            $query->downloadable();

            $vehicles = $query->paginate(100);
        }

        $additional = [
            'timestamp' => $agency->timestamp,
            'count' => count($vehicles),
        ];

        if ($includeGeojson) {
            $additional['geojson'] = GeoJsonVehiclesCollection::make($vehicles);
        }

        return VehicleResource::collection($vehicles)->additional($additional)->preserveQuery();
    }

    public function vehiclesShow(Agency $agency, string $vehicleRef)
    {
        $vehicle = Vehicle::firstWhere([
            'agency_id' => $agency->id,
            'vehicle' => $vehicleRef,
        ]);

        return VehicleResource::make($vehicle);
    }

    public function feed(Request $request, Agency $agency)
    {
        if ($request->input('key') !== config('transittracker.api_key')) {
            return response()->json(['message' => 'Wrong API key!'], 401);
        }

        return Storage::download("feeds/{$agency->slug}");
    }
}
