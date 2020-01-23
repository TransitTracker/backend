<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;

/**
 * Base Vue app
 */
Route::get('/', function () {
    return view('app');
});

/**
 * Auth & base admin
 */
Auth::routes(['register' => false]);
Route::get('admin', 'AdminController@index');

/**
 * Agencies
 */
Route::resource('admin/agencies', 'Admin\AgencyController')->middleware('auth');
Route::post('admin/agencies/{agency}/refresh', 'Admin\AgencyController@refresh')->middleware('auth');
Route::post('admin/agencies/{agency}/gtfsCleanAndUpdate', 'Admin\AgencyController@gtfsCleanAndUpdate')->middleware('auth');
Route::post('admin/agencies/{agency}/gtfsDelete', 'Admin\AgencyController@gtfsDelete')->middleware('auth');
Route::post('admin/agencies/{agency}/gtfsClean', 'Admin\AgencyController@gtfsClean')->middleware('auth');
Route::get('admin/refresh-agencies', function () {
    Artisan::call('agency:refresh-actives');
    return redirect('/admin');
})->middleware('auth');

/**
 * Alerts
 */
Route::resource('admin/alerts', 'Admin\AlertController')->middleware('auth');
Route::post('admin/alerts/{alert}/active', 'Admin\AlertController@active')->middleware('auth');