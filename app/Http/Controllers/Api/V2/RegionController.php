<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Http\Resources\V2\RegionResource;
use App\Models\Region;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;

#[Group('Regions')]
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

    public function index()
    {
        $regions = Region::with(['activeAgencies', 'activeAgencies.regions:slug,name'])->get();

        return RegionResource::collection($regions);
    }

    public function show(Region $region)
    {
        $region->load(['activeAgencies', 'activeAgencies.regions:slug,name']);

        return RegionResource::make($region);
    }

    #[Group('Alerts')]
    public function alerts(Region $region)
    {
        return AlertResource::collection($region->activeAlerts);
    }
}
