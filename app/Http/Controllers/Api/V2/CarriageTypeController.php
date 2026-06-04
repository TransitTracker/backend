<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\CarriageTypeResource;
use App\Models\CarriageType;
use Knuckles\Scribe\Attributes\Group;

#[Group('Carriage Types')]
class CarriageTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,1,v2-carriageTypes;cacheResponse');
    }

    public function index()
    {
        $carriageTypes = CarriageType::select(['id', 'carriage_category', 'make', 'model'])->get();

        return CarriageTypeResource::collection($carriageTypes);
    }
}
