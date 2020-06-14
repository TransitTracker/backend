<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('region', 'RegionCrudController');
    Route::crud('agency', 'AgencyCrudController');
    Route::crud('vehicle', 'VehicleCrudController');
    Route::get('vehicle/{id}/icon', 'VehicleCrudController@icon');
    Route::crud('link', 'LinkCrudController');
    Route::crud('alert', 'AlertCrudController');
}); // this should be the absolute last line of this file