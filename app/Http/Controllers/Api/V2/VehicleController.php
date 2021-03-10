<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Support\Facades\App;

class VehicleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!App::environment('local')) {
            $this->middleware("throttle:30,1,v2-vehicles");
        }

        $this->middleware('cacheResponse:300');
    }

    /**
     * Display the specified resource.
     *
     * @param Vehicle $vehicle
     * @return VehicleResource
     */
    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }
}
