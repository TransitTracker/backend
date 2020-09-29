<?php

use App\Models\Agency;
use App\Models\Alert;
use App\Http\Resources\AlertResource;
use App\Http\Resources\LinkResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\VehiclesCollection;
use App\Models\Link;
use App\Models\Region;
use App\Models\Vehicle;
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

$totalAgencies = env('TOTAL_AGENCIES', count(Agency::select('id')->get()));
$totalAgencies3 = $totalAgencies * 3;

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
})->middleware("throttle:{$totalAgencies3},1,vehicles", 'cacheResponse:300')->name('tt.api.vehicles');

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
})->middleware('throttle:3,1,alert', 'cacheResponse:10000')->name('tt.api.alert');

/*
 * Regions
 */
Route::get('/regions', function () {
    return RegionResource::collection(Region::with('activeAgencies', 'activeAgencies.region:id,slug')->get());
})->middleware('throttle:3,1,regions', 'cacheResponse:10080')->name('tt.api.regions');

/*
 * Dump
 */
Route::get('/dump/{agency}', function (Agency $agency) {
    if (App::environment('local')) {
        app('debugbar')->disable();
    }

    if ((bool) ! $agency->license['is_downloadable']) {
        return response()->json(['message' => 'Download not allowed for this agency.'], 403);
    }

    $fields = ['agency.slug', 'vehicle', 'route', 'gtfs_trip', 'lat', 'lon', 'trip.trip_headsign',
        'trip.trip_short_name', 'trip.route_short_name', 'trip.route_long_name', 'trip.service.service_id', 'bearing',
        'speed', 'start', 'status', 'current_stop_sequence', 'created_at', 'updated_at', 'relationship', 'label',
        'plate', 'odometer', 'timestamp', 'congestion', 'occupancy', ];

    $vehicles = Vehicle::where('agency_id', $agency->id)->get();

    $date = date('Ymd_Hi');
    $fileName = "tt-dump-{$agency->slug}-{$date}.csv";

    $csvExporter = new Export();

    return $csvExporter->build($vehicles, $fields)->download($fileName);
})->middleware("throttle:{$totalAgencies},60,dump", 'cacheResponse:3600')->name('tt.api.dump');

/*
 * Links
 */
Route::get('/links', function () {
    return LinkResource::collection(Link::all());
})->middleware('throttle:3,1,links', 'cacheResponse:10080')->name('tt.api.links');

/*
 * Fallback (404)
 */
Route::fallback(function () {
    return response()->json(['message' => 'API_ENDPOINT_NOT_FOUND'], 404);
});
