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

Route::get('/', function () {
    return view('app');
});

Auth::routes(['register' => false]);

Route::get('/admin', 'AdminController@index');
Route::resource('admin/agencies', 'Admin\AgencyController')->middleware('auth');
Route::resource('admin/alerts', 'Admin\AlertController')->middleware('auth');
Route::post('admin/alerts/{alert}/active', 'Admin\AlertController@active')->middleware('auth');