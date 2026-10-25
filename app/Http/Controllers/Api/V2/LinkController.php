<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\LinkResource;
use App\Models\Link;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

#[Group('Links')]
class LinkController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! App::environment('local', 'testing')) {
            $totalLinks = ceil(1.5 * Link::count());
            $this->middleware("throttle:{$totalLinks},1,v2-links");
        }

        $this->middleware(CacheResponse::for(days(7), tags: ['links']));
    }

    /**
     * List reference links
     *
     * Retrieve all active external reference links.
     */
    public function index()
    {
        $links = Link::active()->get();

        return LinkResource::collection($links);
    }

    /**
     * Get link details
     *
     * Retrieve details for a single external reference link by its ID.
     */
    #[PathParameter('linkId', description: 'Internal database ID of the external link.', type: 'int', example: 1)]
    public function show(int $linkId)
    {
        $link = Link::active()->findOrFail($linkId);

        return LinkResource::make($link);
    }
}
