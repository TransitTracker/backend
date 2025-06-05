<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\GeoJsonLandingCollection;
use App\Http\Resources\V2\GeoJsonLandingVehicleCollection;
use App\Models\Region;
use App\Models\Vehicle;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;

#[Group('Landing', 'GeoJSON ressources used on the landing page')]
class LandingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! App::environment('local')) {
            $this->middleware('throttle:5,1,v2-landing');
        }

        $this->middleware('cache.headers:public,max-age=600');

        $this->middleware('cacheResponse:600');
    }

    public function index()
    {
        $regions = Region::query()
            ->select(['id', 'name', 'slug', 'map_zoom', 'map_center'])
            ->with(['activeAgencies:id,cities'])
            ->withCount(['activeAgencies'])
            ->get();

        $totalVehiclesRecorded = Vehicle::count();

        return GeoJsonLandingCollection::make($regions)
            ->additional(['stats' => [
                'totalVehiclesRecorded' => $totalVehiclesRecorded,
            ]]);
    }

    public function vehicles()
    {
        return GeoJsonLandingVehicleCollection::make(
            Vehicle::active()->select(['id', 'position'])->get()
        );
    }
}
