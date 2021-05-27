<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SnoozeFailedJobController;
use Illuminate\Support\Facades\App;

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
 * Beta redirect route
 */
Route::get('/beta/{lang?}', function ($lang = 'en') {
    if (! in_array($lang, ['en', 'fr'])) {
        abort(400);
    }

    App::setLocale($lang);

    return view('beta');
})->name('tt.beta');

/*
 * Signed route to snooze failed job notification
 */
Route::get('/failed-job/{failedJob}/snooze/{hours}', [SnoozeFailedJobController::class, 'snooze'])->middleware('signed')->name('signed.snooze');

Route::view('/login', 'auth.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
