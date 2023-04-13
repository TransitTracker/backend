<?php

use App\Http\Controllers\Admin\AgencyController;
use App\Http\Controllers\Admin\FailedJobController;

// Admin routes
Route::domain(config('filament.domain'))->prefix('ext/internal/')->middleware('signed')->group(function () {
    Route::get('agencies/{agency}/update', [AgencyController::class, 'update'])->name('internal.agencies.static-update');
    Route::get('failed-job/{failedJob}/snooze/{hours}', [FailedJobController::class, 'snooze'])->name('internal.failed-jobs.snooze');
});

Route::fallback(function () {
    return redirect()->route('scribe');
});
