<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class VehicleController extends Controller
{
    public function __construct()
    {
        $vehiclesChunk = (Vehicle::count() / 500) + 5;

        if (! App::environment('local')) {
            $this->middleware('throttle:30,1,v2-vehicles')->except('index');
            $this->middleware("throttle:{$vehiclesChunk},1,v2-vehicles")->only('index');
        }

        $this->middleware('cacheResponse:300');
    }

    public function index(Request $request)
    {
        $this->middleware('cacheResponse:900');

        $request->request->add(['include' => 'all']);

        $vehicles = Vehicle::query()
            ->downloadable()
            ->with(['trip', 'links:id', 'agency:id,slug,name', 'trip.service:service_id'])
            ->paginate(500);

        return VehicleResource::collection($vehicles);
    }

    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }
}
