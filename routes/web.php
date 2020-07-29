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

/*
 * Base Vue app
 */

use App\Http\Controllers\SnoozeFailedJobController;

Route::get('/', function () {
    return view('app');
})->name('tt.app');

/*
 * Opt-out from statistics
 */
Route::get('/opt-out/{lang?}', function ($lang = 'en') {
    return view('opt-out', compact('lang'));
})->name('tt.opt-out');

/*
 * Signed route to snooze failed job notification
 */
Route::get('/failed-job/{failedJob}/snooze/{hours}', [SnoozeFailedJobController::class, 'snooze'])->middleware('signed')->name('signed.snooze');
