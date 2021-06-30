<?php

namespace App\Actions;

use App\Models\Agency;
use App\Models\FailedJob;
use App\Models\User;
use App\Notifications\StaticGtfsExpired;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class HandleExpiredGtfs
{
    private Agency $agency;

    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    public function execute()
    {
        $failedJob = FailedJob::firstWhere([
            'name' => 'App\\Jobs\\RealtimeData\\GtfsRtHandler',
            'agency_id' => $this->agency->id,
            'exception' => 'expiredGtfs',
        ]);

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now()->addDay())) {
            // Do nothing
        } elseif ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now())) {
            // Update but do not send
            $failedJob->snooze = now()->addDay();
            $failedJob->save();
        } elseif ($failedJob) {
            // Update and send
            $failedJob->snooze = now()->addDay();
            $failedJob->save();
            $this->sendNotification();
        } else {
            $failedJob = FailedJob::create([
                'name' => 'App\\Jobs\\RealtimeData\\GtfsRtHandler',
                'agency_id' => $this->agency->id,
                'exception' => 'expiredGtfs',
                'snooze' => now()->addDay(),
            ]);
            $this->sendNotification();
        }
    }

    private function sendNotification()
    {
        Notification::send([User::first()], new StaticGtfsExpired($this->agency));
    }
}
