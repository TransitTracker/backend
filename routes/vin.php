<?php

use App\Http\Controllers\Vin\AgencyController;
use App\Http\Controllers\Vin\OperatorController;
use App\Http\Controllers\Vin\SuggestionController;
use App\Http\Controllers\Vin\VehicleController;
use Illuminate\Support\Facades\App;

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
Route::get('sector/{sector}', [AgencyController::class, 'show'])->name('vin.agency.show');
Route::get('operator/{tagSlug}', [OperatorController::class, 'show'])->name('vin.operator.show');
Route::post('vin/{suggestion}/vote', [SuggestionController::class, 'vote'])->name('vin.vote');
Route::post('vin/{suggestion}/approve/{agency?}', [SuggestionController::class, 'approve'])->middleware('auth')->name('vin.approve');
Route::post('vin/{suggestion}/reject', [SuggestionController::class, 'reject'])->middleware('auth')->name('vin.reject');
