<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\GeoJsonLandingCollection;
use App\Http\Resources\V2\GeoJsonLandingVehicleCollection;
use App\Models\Region;
use App\Models\Vehicle;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\minutes;

#[Group('Landing')]
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

        $this->middleware(CacheResponse::for(minutes(10), tags: ['regions']));
    }

    /**
     * Get landing map regions and stats
     *
     * Retrieve a GeoJSON FeatureCollection of transit regions with their active agencies, map positioning, and overall vehicle statistics.
     */
    public function index()
    {
        $regions = Region::query()
            ->select(['id', 'name', 'slug', 'map_zoom', 'map_center', 'image'])
            ->with(['activeAgencies:id,cities'])
            ->withCount(['activeAgencies'])
            ->orderBy('order_id')
            ->get();

        $totalVehiclesRecorded = Vehicle::count();

        return GeoJsonLandingCollection::make($regions)
            ->additional(['stats' => [
                'totalVehiclesRecorded' => $totalVehiclesRecorded,
            ]]);
    }

    /**
     * Get live vehicle coordinates for landing map
     *
     * Retrieve lightweight GeoJSON Point coordinates of all currently active transit vehicles for homepage map visualizations.
     */
    public function vehicles()
    {
        return GeoJsonLandingVehicleCollection::make(
            Vehicle::active()->select(['id', 'position'])->get()
        );
    }
}
