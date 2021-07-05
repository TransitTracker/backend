<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Http\Resources\V2\RegionResource;
use App\Models\Region;
use Illuminate\Support\Facades\App;

class RegionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalRegions = 2 * Region::count();

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalRegions},1,v2-regions");
        }

        $this->middleware('cacheResponse');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $regions = Region::with(['activeAgencies', 'activeAgencies.regions:slug,name'])->get();

        return RegionResource::collection($regions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return RegionResource
     */
    public function show(Region $region)
    {
        return RegionResource::make($region);
    }

    /**
     * Display a listing of alerts from the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function alerts(Region $region)
    {
        return AlertResource::collection($region->activeAlerts);
    }
}
