<?php

use App\Agency;
use App\Alert;
use App\Http\Resources\AlertResource;
use App\Http\Resources\GeojsonVehiclesCollection;
use App\Http\Resources\LinkResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\VehiclesCollection;
use App\Link;
use App\Region;
use App\Vehicle;
use Laracsv\Export;

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

/*
 * Vehicles
 */
Route::get('/vehicles/{agency}', function (Agency $agency) {
    if ($agency->is_active) {
        $vehicles = Vehicle::where([['active', true], ['agency_id', $agency->id]])->with(['trip', 'links:link_id'])->get();

        return (new VehiclesCollection($vehicles))
            ->additional([
                'timestamp' => $agency->timestamp,
            ]);
    } else {
        return response()->json(['message' => 'AGENCY_INACTIVE'], 403);
    }
})->middleware('cacheResponse:300')->name('tt.api.vehicles');

Route::get('/geojson/{agency}', function (Agency $agency) {
    if ($agency->is_active) {
        $vehicles = Vehicle::where(['active' => true, 'agency_id' => $agency->id])->select('id', 'active', 'icon', 'lat', 'lon')->get();

        return new GeojsonVehiclesCollection($vehicles);
    } else {
        return response()->json(['message' => 'AGENCY_INACTIVE'], 403);
    }
})->middleware('cacheResponse:300')->name('tt.api.vehicles');

/*
 * Alerts
 */
Route::get('/alert', function () {
    $alert = Alert::where('is_active', 1)->first();

    if ($alert) {
        return new AlertResource($alert);
    } else {
        return response()->json(['message' => 'NO_ACTIVE_ALERT'], 200);
    }
})->middleware('cacheResponse:10000')->name('tt.api.alert');

/*
 * Regions
 */
Route::get('/regions', function () {
    return RegionResource::collection(Region::with('agencies')->get());
})->middleware('cacheResponse:10080')->name('tt.api.regions');

/*
 * Dump
 */
Route::get('/dump/{agency}', function (Agency $agency) {
    app('debugbar')->disable();

    $fields = ['agency.slug', 'vehicle', 'route', 'gtfs_trip', 'lat', 'lon', 'trip.trip_headsign',
        'trip.trip_short_name', 'trip.route_long_name', 'trip.service.service_id', 'bearing', 'speed', 'start',
        'status', 'current_stop_sequence', 'created_at', 'updated_at', ];

    $vehicles = Vehicle::where('agency_id', $agency->id)->get();

    $fileName = 'mtltt-dump-'.$agency->slug.'-'.date('Ymd_Hi').'.csv';

    $csvExporter = new Export();

    return $csvExporter->build($vehicles, $fields)->download($fileName);
})->middleware('cacheResponse:3600')->name('tt.api.dump');

/*
 * Links
 */
Route::get('/links', function () {
    return LinkResource::collection(Link::all());
})->middleware('cacheResponse:10080')->name('tt.api.links');

/*
 * Fallback (404)
 */
Route::fallback(function () {
    return response()->json(['message' => 'API_ENDPOINT_NOT_FOUND'], 404);
});
