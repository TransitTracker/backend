<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\CarriageTypeResource;
use App\Models\CarriageType;
use Knuckles\Scribe\Attributes\Group;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

#[Group('Carriage Types')]
class CarriageTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,1,v2-carriageTypes');
        $this->middleware(CacheResponse::for(days(7), tags: ['carriageTypes']));
    }

    public function index()
    {
        $carriageTypes = CarriageType::select(['id', 'carriage_category', 'make', 'model'])->get();

        return CarriageTypeResource::collection($carriageTypes);
    }
}
