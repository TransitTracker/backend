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
Route::get('locale/{locale}', function ($locale) {
    if (! array_key_exists($locale, config('app.supported_languages'))) {
        $locale = 'en';
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('agencies/{agency}/update', [AgencyController::class, 'update'])->name('admin.agencies.update');
});

// VIN routes
Route::prefix('vin')->group(function () {
    Route::get('', [VinController::class, 'index'])->name('vin.index');
    Route::get('{vin}', [VinController::class, 'show'])->name('vin.show');
    Route::post('{vin}', [VinController::class, 'store'])->name('vin.store');
    Route::post('suggestions/{vinSuggestion}/vote', [VinController::class, 'vote'])->name('vin.vote');
    Route::post('suggestions/{vinSuggestion}/approve/{agency?}', [VinController::class, 'approve'])->middleware('auth')->name('vin.approve');
    Route::post('suggestions/{vinSuggestion}/delete', [VinController::class, 'delete'])->middleware('auth')->name('vin.delete');
});

Route::get('/failed-job/{failedJob}/snooze/{hours}', [SnoozeFailedJobController::class, 'snooze'])->middleware('signed')->name('signed.snooze');

Route::view('/login', 'auth.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
