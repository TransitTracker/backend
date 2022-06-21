<?php

use App\Http\Controllers\Api\V1\V1AlertController;
use App\Http\Controllers\Api\V1\V1LinkController;
use App\Http\Controllers\Api\V1\V1RegionController;
use App\Http\Controllers\Api\V1\V1VehicleController;
use App\Http\Controllers\Api\V2\AgencyController;
use App\Http\Controllers\Api\V2\AlertController;
use App\Http\Controllers\Api\V2\LandingController;
use App\Http\Controllers\Api\V2\LinkController;
use App\Http\Controllers\Api\V2\NotificationsController;
use App\Http\Controllers\Api\V2\Push\ProfileController;
use App\Http\Controllers\Api\V2\RegionController;
use App\Http\Controllers\Api\V2\VehicleController;
use App\Http\Middleware\Localization;

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

foreach (['api', 'v1'] as $apiGroup) {
    Route::prefix($apiGroup)->group(function () use ($apiGroup) {
        $totalAgencies = env('TOTAL_AGENCIES', 30);
        $totalAgencies3 = $totalAgencies * 3;

        $expansion = $apiGroup === 'v1' ? '' : '.old';

        /*
         * Vehicles
         */
        Route::get('/vehicles/{agency}', [V1VehicleController::class, 'show'])->middleware("throttle:{$totalAgencies3},1,vehicles", 'cacheResponse:300')->name("tt.api.vehicles{$expansion}");

        /*
         * Alerts
         */
        Route::get('/alert', [V1AlertController::class, 'index'])->middleware('throttle:3,1,alert', 'cacheResponse:10000')->name("tt.api.alert{$expansion}");

        /*
         * Regions
         */
        Route::get('/regions', [V1RegionController::class, 'index'])->middleware('throttle:3,1,regions', 'cacheResponse:10080')->name("tt.api.regions{$expansion}");

        /*
         * Dump
         */
        Route::get('/dump/{agency}', [V1VehicleController::class, 'dump'])->middleware("throttle:{$totalAgencies},60,dump")->name("tt.api.dump{$expansion}");

        /*
         * Links
         */
        Route::get('/links', [V1LinkController::class, 'index'])->middleware('throttle:3,1,links', 'cacheResponse:10080')->name("tt.api.links{$expansion}");

        /*
         * Fallback (404)
         */
        Route::fallback(fn () => response()->json(['message' => 'API_ENDPOINT_NOT_FOUND'], 404));
    });
}

Route::prefix('v2')->middleware(Localization::class)->group(function () {
    Route::get('agencies', [AgencyController::class, 'index']);
    Route::get('agencies/{agency}', [AgencyController::class, 'show']);
    Route::get('agencies/{agency}/vehicles', [AgencyController::class, 'vehicles']);
    Route::get('agencies/{agency}/feed', [AgencyController::class, 'feed']);
    Route::get('alerts', [AlertController::class, 'index']);
    Route::get('alerts/{alert}', [AlertController::class, 'show']);
    Route::get('landing', [LandingController::class, 'index']);
    Route::get('links', [LinkController::class, 'index']);
    Route::get('links/{link}', [LinkController::class, 'show']);
    Route::get('regions', [RegionController::class, 'index']);
    Route::get('regions/{region}', [RegionController::class, 'show']);
    Route::get('regions/{region}/alerts', [RegionController::class, 'alerts']);
    Route::get('vehicles', [VehicleController::class, 'index']);
    Route::get('vehicles/{vehicle}', [VehicleController::class, 'show']);

    Route::get('push/profile', [ProfileController::class, 'show']);
    Route::put('push/profile', [ProfileController::class, 'update']);
    Route::delete('push/profile', [ProfileController::class, 'destroy']);
    Route::post('push/profile', [ProfileController::class, 'store']);
    Route::post('push/profile/verify', [ProfileController::class, 'verify']);
    Route::get('push/notifications/agencies', [NotificationsController::class, 'agencies']);

    Route::fallback(fn () => response()->json(['message' => 'Route not found.'], 404));
});
