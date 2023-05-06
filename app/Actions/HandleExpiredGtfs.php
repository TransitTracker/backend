<?php

namespace App\Actions;

use App\Jobs\RealtimeData\GtfsRtHandler;
use App\Models\Agency;
use App\Models\FailedJob;
use App\Models\User;
use App\Notifications\StaticGtfsExpired;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class HandleExpiredGtfs
{
    public function __construct(private Agency $agency)
    {
    }

    public function execute()
    {
        $failedJob = FailedJob::firstWhere([
            'name' => GtfsRtHandler::class,
            'agency_id' => $this->agency->id,
            'exception' => 'expiredGtfs',
        ]);

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now()->addDay())) {
            return;
        }

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now())) {
            // Update but do not send
            $failedJob->snooze = now()->addDay();
            $failedJob->save();
            return;
        }

        if ($failedJob) {
            // Update and send
            $failedJob->snooze = now()->addDay();
            $failedJob->save();
            $this->sendNotification();
            return;
        }

        FailedJob::create([
            'name' => GtfsRtHandler::class,
            'agency_id' => $this->agency->id,
            'exception' => 'expiredGtfs',
            'snooze' => now()->addDay(),
        ]);
        $this->sendNotification();
    }

    private function sendNotification()
    {
        Notification::send([User::first()], new StaticGtfsExpired($this->agency));
    }
}
