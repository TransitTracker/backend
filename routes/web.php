<?php

Route::fallback(function () {
    if (request()->segment(1) === 'vin') {
        return redirect(route('vin.index'))->with('from-api', true);
    }

    return redirect()->route('scribe');
});
