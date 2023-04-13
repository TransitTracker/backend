<?php

use App\Http\Controllers\Vin\AgencyController;
use App\Http\Controllers\Vin\SuggestionController;
use App\Http\Controllers\Vin\VehicleController;
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
Route::get('locale/{locale}', function ($locale) {
    if (! array_key_exists($locale, config('app.supported_languages'))) {
        $locale = 'en';
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');

// VIN routes
Route::get('', [SuggestionController::class, 'index'])->name('vin.index');
Route::get('{vin}', [VehicleController::class, 'show'])->name('vin.show');
Route::post('{vin}', [SuggestionController::class, 'store'])->name('vin.store');
Route::get('agency/{agency}', [AgencyController::class, 'show'])->name('vin.agency.show');
Route::post('agency/{agency}', [AgencyController::class, 'store'])->middleware('auth')->name('vin.agency.store');
Route::post('vin/{suggestion}/vote', [SuggestionController::class, 'vote'])->name('vin.vote');
Route::post('vin/{suggestion}/approve/{agency?}', [SuggestionController::class, 'approve'])->middleware('auth')->name('vin.approve');
Route::post('vin/{suggestion}/reject', [SuggestionController::class, 'reject'])->middleware('auth')->name('vin.reject');
