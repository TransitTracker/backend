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

class AgencyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalAgencies = 3 * count(Agency::pluck('id'));

        if (!App::environment('local')) {
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
        $agencies = Agency::active()->get();

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
        if (!$agency->is_active) {
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
        if (!$agency->is_active) {
            return response()->json(['message' => 'Agency is inactive.'], 403);
        }

        $vehicles = Vehicle::whereActive($request->include ? $request->include !== 'all' : true)
            ->whereAgencyId($agency->id)
            ->with(['trip', 'links:id', 'agency:id,slug'])
            ->get();

        return VehicleResource::collection($vehicles)->additional([
            'geojson' => GeoJsonVehiclesCollection::make($vehicles),
            'timestamp' => $agency->timestamp,
            'count' => count($vehicles)
        ]);
    }
}
