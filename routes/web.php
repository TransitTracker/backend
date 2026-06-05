<?php

use App\Http\Controllers\Vin\RegionImageController;

Route::get('forms/region-images', [RegionImageController::class, 'create'])->name('forms.region-image.create');
Route::post('forms/region-images', [RegionImageController::class, 'store'])->name('forms.region-image.store')->middleware('throttle:5,1');

Route::fallback(function () {
    if (request()->segment(1) === 'vin') {
        return redirect(route('vin.index'))->with('from-api', true);
    }

    return redirect()->route('scribe');
});
