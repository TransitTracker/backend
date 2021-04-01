<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\GeoJsonLandingCollection;
use App\Http\Resources\V2\GeoJsonLandingResource;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Log;

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

        $this->middleware('cacheResponse');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $regions = Region::with(['activeAgencies:id'])->withCount('agencies')->get();

        return GeoJsonLandingCollection::make($regions);
    }
}
