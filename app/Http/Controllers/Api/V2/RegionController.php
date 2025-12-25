<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Http\Resources\V2\RegionResource;
use App\Models\Alert;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
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
    public function alerts($regionSlug)
    {
        $regionId = Region::where('slug', $regionSlug)->select('id')->pluck('id')->firstOrFail();

        $alerts = Alert::active()
            ->where(function (Builder $query) use ($regionId) {
                return $query
                    ->where('is_regional', false)
                    ->orWhereHas('regions', function (Builder $query) use ($regionId) {
                        $query->where('region_id', $regionId);
                    });
            })
            ->select(['id', 'title', 'subtitle', 'created_at', 'body', 'color', 'icon', 'action', 'action_parameters', 'image', 'category', 'status'])
            ->with(['regions:id,slug'])
            ->orderBy('created_at', 'desc')
            ->get();

        return AlertResource::collection($alerts);
    }
}
