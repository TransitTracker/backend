<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\LinkResource;
use App\Models\Link;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

#[Group('Link')]
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

        $this->middleware(CacheResponse::for(days(7), tags: ['links']));
    }

    public function index()
    {
        $links = Link::active()->get();

        return LinkResource::collection($links);
    }

    public function show(int $linkId)
    {
        $link = Link::active()->findOrFail($linkId);

        return LinkResource::make($link);
    }
}
