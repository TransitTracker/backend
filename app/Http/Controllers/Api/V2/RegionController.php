<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Http\Resources\V2\RegionResource;
use App\Models\Alert;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;
use Spatie\ResponseCache\Attributes\Cache;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

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

        $this->middleware(CacheResponse::for(days(7), tags: ['regions']))->except(['alerts']);
    }

    public function index()
    {
        $regions = Region::query()
            ->orderBy('order_id')
            ->with([
                'activeAgencies' => function (BelongsToMany $query) {
                  $query->orderBy('order_id');
                },
                'activeAgencies.regions' => function (BelongsToMany $query) {
                  $query->select(['slug', 'name'])->orderBy('order_id');
                },
            ])
            ->get();

        return RegionResource::collection($regions);
    }

    public function show(Region $region)
    {
        $region
            ->load([
                'activeAgencies' => function (BelongsToMany $query) {
                    $query->orderBy('order_id');
                },
                'activeAgencies.regions' => function (BelongsToMany $query) {
                    $query->select(['slug', 'name'])->orderBy('order_id');
                },
            ]);

        return RegionResource::make($region);
    }

    #[Group('Alerts')]
    #[Cache(lifetime: 60 * 60 * 24 * 7, tags: ['alerts'])]
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
            ->with(['regions' => function ($query) {
                $query->select('slug')->orderBy('order_id');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return AlertResource::collection($alerts);
    }
}
