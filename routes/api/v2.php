<?php

use App\Http\Controllers\Api\V2\AgencyController;
use App\Http\Controllers\Api\V2\AlertController;
use App\Http\Controllers\Api\V2\BlockController;
use App\Http\Controllers\Api\V2\LandingController;
use App\Http\Controllers\Api\V2\LinkController;
use App\Http\Controllers\Api\V2\NotificationsController;
use App\Http\Controllers\Api\V2\Push\ProfileController;
use App\Http\Controllers\Api\V2\Push\ProfileVehiclesController;
use App\Http\Controllers\Api\V2\RegionController;
use App\Http\Controllers\Api\V2\ShapeController;
use App\Http\Controllers\Api\V2\TagController;
use App\Http\Controllers\Api\V2\VehicleController;
use Illuminate\Http\Request;

Route::get('agencies', [AgencyController::class, 'index']);
Route::get('agencies/{agency}', [AgencyController::class, 'show']);
Route::get('agencies/{agency}/vehicles', [AgencyController::class, 'vehicles']);
Route::get('agencies/{agency}/vehicles.geojson', [AgencyController::class, 'vehiclesGeoJson']);
Route::get('agencies/{agency}/vehicles/{vehicle}', [AgencyController::class, 'vehiclesShow']);
Route::get('agencies/{agency}/vehicles.geojson/{vehicle}', [AgencyController::class, 'vehiclesGeoJsonShow']);
Route::get('agencies/{agency}/feed', [AgencyController::class, 'feed']);
Route::get('agencies/{agencySlug}/trips/{tripId}/blocks', [BlockController::class, 'show']);
Route::get('agencies/{agencySlug}/shapes/{shapeId}', [ShapeController::class, 'show']);

Route::get('alerts', [AlertController::class, 'index']);
Route::get('alerts/{alert}', [AlertController::class, 'show']);

Route::get('landing', [LandingController::class, 'index']);
Route::get('landing/vehicles', [LandingController::class, 'vehicles']);

Route::get('links', [LinkController::class, 'index']);
Route::get('links/{link}', [LinkController::class, 'show']);

Route::get('regions', [RegionController::class, 'index']);
Route::get('regions/{region}', [RegionController::class, 'show']);
Route::get('regions/{region}/alerts', [RegionController::class, 'alerts']);

Route::get('tags', [TagController::class, 'index']);
Route::get('tags/{tag}', [TagController::class, 'show']);

Route::get('vehicles', [VehicleController::class, 'index']);
Route::get('vehicles.geojson', [VehicleController::class, 'indexGeoJson']);
Route::get('vehicles/{vehicle}', [VehicleController::class, 'show']);
Route::get('vehicles.geojson/{vehicle}', [VehicleController::class, 'showGeoJson']);

Route::get('push/profile', [ProfileController::class, 'show']);
Route::put('push/profile', [ProfileController::class, 'update']);
Route::delete('push/profile', [ProfileController::class, 'destroy']);
Route::post('push/profile', [ProfileController::class, 'store']);
Route::post('push/profile/verify', [ProfileController::class, 'verify']);

Route::post('push/profile/vehicles', [ProfileVehiclesController::class, 'store']);
Route::delete('push/profile/vehicles', [ProfileVehiclesController::class, 'destroy']);

Route::get('push/notifications/agencies', [NotificationsController::class, 'agencies']);

Route::middleware('auth:sanctum')->get('admin/user', function (Request $request) {
    return $request->user();
});

Route::fallback(fn () => response()->json(['message' => 'Route not found.'], 404));
