<?php

use App\Alert;
use App\Agency;
use App\Vehicle;
use App\Http\Resources\AlertCollection;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\AgencyCollection;
use App\Http\Resources\VehiclesCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vehicles/{agency}', function (Agency $agency) {
    $vehicles = Vehicle::where([['active', true], ['agency_id', $agency->id]])->get();

    return (new VehiclesCollection($vehicles))
                ->additional([
                    'timestamp' => $agency->timestamp
                ]);
});

Route::get('/alerts', function () {
    return new AlertCollection(Alert::where('expiration', '>', Carbon::today()->toDateTimeString())->get());
});

Route::get('/agencies', function () {
    return new AgencyCollection(Agency::select(['id', 'name', 'color', 'text_color', 'vehicles_type', 'slug'])->get());
});

Route::fallback(function () {
    return response()->json(['message' => 'Not found.'], 404);
});
//Route::fallback(function () {
//    return response()->json(['message' => 'Not found.'], 404);
//})->name('api.fallback.404');