<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\TagResource;
use App\Models\Tag;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;

#[Group('Tags')]
class TagController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalLinks = ceil(1.5 * Tag::count());

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalLinks},1,v2-tags");
        }

        $this->middleware('cacheResponse');
    }

    public function index()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    public function show(Tag $tag)
    {
        return TagResource::make($tag);
    }
}
