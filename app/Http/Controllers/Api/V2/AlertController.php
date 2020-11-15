<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Models\Alert;

class AlertController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalAlerts = ceil(1.5 * count(Alert::active()->pluck('id')));

        $this->middleware("throttle:{$totalAlerts},1,v2-alerts");

        $this->middleware('cacheResponse');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $alerts = Alert::active()->get();

        return AlertResource::collection($alerts);
    }

    /**
     * Display the specified resource.
     *
     * @param Alert $alert
     * @return AlertResource
     */
    public function show(Alert $alert)
    {
        return AlertResource::make($alert);
    }
}
