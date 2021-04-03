<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\LinkResource;
use App\Models\Link;
use Illuminate\Support\Facades\App;

class LinkController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalLinks = ceil(1.5 * Link::count());

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalLinks},1,v2-links");
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
        $links = Link::all();

        return LinkResource::collection($links);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return LinkResource
     */
    public function show(Link $link)
    {
        return LinkResource::make($link);
    }
}
