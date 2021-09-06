<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AgencyResource;
use App\Http\Resources\V2\GeoJsonVehiclesCollection;
use App\Http\Resources\V2\VehicleResource;
use App\Models\Agency;
use App\Models\Vehicle;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Storage;

class AgencyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalAgencies = 3 * Agency::active()->count();

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalAgencies},1,v2-agencies");
        }

        $this->middleware('cacheResponse')->except('vehicles');
        $this->middleware('cacheResponse:300')->only('vehicles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $agencies = Agency::active()->with('regions:slug')->get();

        return AgencyResource::collection($agencies);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Agency $agency
     * @return AgencyResource
     */
    public function show(Agency $agency)
    {
        if (! $agency->is_active) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        return AgencyResource::make($agency);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
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
            ->with(['trip', 'links:id', 'agency:id,slug,name', 'trip.service:service_id']);

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

    /**
     * Display the agency realtime feed (when special API key is provided).
     *
     * @param  \App\Models\Agency  $agency
     * @return LinkResource
     */
    public function feed(Request $request, Agency $agency)
    {
        if ($request->input('key') !== config('transittracker.api_key')) {
            return response()->json(['message' => 'Wrong API key!'], 401);
        }

        return Storage::download("feeds/{$agency->slug}");
    }
}
