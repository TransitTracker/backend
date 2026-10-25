<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\TagResource;
use App\Models\Tag;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

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
        if (! App::environment('local', 'testing')) {
            $totalLinks = ceil(1.5 * Tag::count());
            $this->middleware("throttle:{$totalLinks},1,v2-tags");
        }

        $this->middleware(CacheResponse::for(days(7), tags: ['tags']));
    }

    /**
     * List vehicle tags
     *
     * Retrieve all vehicle attribute tags (liveries, special series, notable fleet features).
     */
    public function index()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    /**
     * Get tag details
     *
     * Retrieve details for a single vehicle tag by its ID.
     */
    #[PathParameter('tag', description: 'Tag ID.', type: 'int', example: 1)]
    public function show(Tag $tag)
    {
        return TagResource::make($tag);
    }
}
