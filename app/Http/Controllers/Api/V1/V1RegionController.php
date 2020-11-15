<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;

class V1RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return RegionResource::collection(Region::with('activeAgencies', 'activeAgencies.regions:id,slug')->get());
    }
}
