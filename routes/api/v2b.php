<?php

Route::get('agencies/{agency}/vehicles', [\App\Http\Controllers\Api\V2b\AgencyController::class, 'vehicles']);

Route::fallback(fn () => response()->json(['message' => 'Route not found in v2b.'], 404));
