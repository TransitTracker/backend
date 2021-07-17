<?php

use App\Http\Controllers\Api\Admin\AgencyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SnoozeFailedJobController;
use App\Http\Controllers\VinController;
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
Route::get('/fr', function () {
    App::setLocale('fr');

    return view('home');
})->name('tt.dev.landing.fr');

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

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('agencies/{agency}/update', [AgencyController::class, 'update'])->name('admin.agencies.update');
});

// VIN routes
Route::prefix('vin')->group(function () {
    Route::get('', [VinController::class, 'index'])->middleware('auth')->name('vin.index');
    Route::get('{vin}', [VinController::class, 'show'])->name('vin.show');
    Route::get('{vin}/fr', [VinController::class, 'showFr'])->name('vin.show.fr');
    Route::post('{vin}', [VinController::class, 'store'])->name('vin.store');
    Route::post('{vin}/fr', [VinController::class, 'storeFr'])->name('vin.store.fr');
    Route::post('suggestions/{vinSuggestion}/vote', [VinController::class, 'vote'])->name('vin.vote');
    Route::post('suggestions/{vinSuggestion}/approve', [VinController::class, 'approve'])->middleware('auth')->name('vin.approve');
    Route::post('suggestions/{vinSuggestion}/delete', [VinController::class, 'delete'])->middleware('auth')->name('vin.delete');
});

Route::get('/failed-job/{failedJob}/snooze/{hours}', [SnoozeFailedJobController::class, 'snooze'])->middleware('signed')->name('signed.snooze');

Route::view('/login', 'auth.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
