<?php

use App\Alert;
use App\Agency;
use App\Vehicle;
use App\Http\Resources\AlertResource;
use App\Http\Resources\AgencyCollection;
use App\Http\Resources\VehiclesCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/vehicles/{agency}', function (Agency $agency) {
    if ($agency->is_active) {
        $vehicles = Vehicle::where([['active', true], ['agency_id', $agency->id]])->get();

        return (new VehiclesCollection($vehicles))
            ->additional([
                'timestamp' => $agency->timestamp
            ]);
    } else {
        return response()->json(['message' => 'AGENCY_INACTIVE'], 403);
    }
})->middleware('cacheResponse:300,vehicles');

Route::get('/alert', function () {
    $alert = Alert::where('is_active', 1)->first();

    if ($alert) {
        return new AlertResource($alert);
    } else {
        return response()->json(['message' => 'NO_ACTIVE_ALERT'], 200);
    }
    // Todo: fix tag cache
//})->middleware('cacheResponse:10000,alerts');
});

Route::get('/agencies', function () {
    return new AgencyCollection(Agency::where('is_active', true)->select(['id', 'name', 'color', 'text_color', 'vehicles_type', 'slug', 'is_active'])->get());
})->middleware('cacheResponse:10080,agencies');

Route::fallback(function () {
    return response()->json(['message' => 'API_ENDPOINT_NOT_FOUND'], 404);
});