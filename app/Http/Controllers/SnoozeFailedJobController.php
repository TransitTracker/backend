<?php

namespace App\Http\Controllers;

use App\FailedJob;

class SnoozeFailedJobController extends Controller
{
    public function snooze(FailedJob $failedJob, int $hours)
    {
        $failedJob->snooze = now()->addHours($hours);
        $failedJob->save();

        return redirect('/admin/dashboard');
    }
}
