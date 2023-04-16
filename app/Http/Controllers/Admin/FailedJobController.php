<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FailedJob;

class FailedJobController extends Controller
{
    public function snooze(FailedJob $failedJob, int $hours)
    {
        $failedJob->snooze = now()->addHours($hours);
        $failedJob->save();

        return redirect()->route('filament.pages.dashboard');
    }
}
