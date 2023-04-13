<?php

use App\Http\Controllers\Api\Admin\AgencyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SnoozeFailedJobController;
use App\Http\Controllers\Vin\AgencyController as VinAgencyController;
use App\Http\Controllers\Vin\SuggestionController;
use App\Http\Controllers\Vin\VehicleController as VinVehicleController;
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
 * Developer site
 */
Route::view('/', 'home')->name('tt.dev.landing');
Route::get('locale/{locale}', function ($locale) {
    if (! array_key_exists($locale, config('app.supported_languages'))) {
        $locale = 'en';
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('agencies/{agency}/update', [AgencyController::class, 'update'])->name('admin.agencies.update');
});

Route::get('/failed-job/{failedJob}/snooze/{hours}', [SnoozeFailedJobController::class, 'snooze'])->middleware('signed')->name('signed.snooze');

Route::view('/login', 'auth.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
