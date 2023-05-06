<?php

namespace App\Actions;

use App\Jobs\RealtimeData\CheckTimestamps;
use App\Models\Agency;
use App\Models\FailedJob;
use App\Models\User;
use App\Notifications\RealtimeDataExpired;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class HandleExpiredRealtimeData
{
    public function __construct(private Agency $agency)
    {
    }

    public function execute()
    {
        $failedJob = FailedJob::firstWhere([
            'name' => CheckTimestamps::class,
            'agency_id' => $this->agency->id,
            'exception' => 'expiredRealtimeData',
        ]);

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now()->addMinutes(30))) {
            return;
        }

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now())) {
            // Update but do not send
            $failedJob->snooze = now()->addMinutes(30);
            $failedJob->save();
            return;
        }

        if ($failedJob) {
            // Update and send
            $failedJob->snooze = now()->addMinutes(30);
            $failedJob->save();
            $this->sendNotification();
            return;
        }

        FailedJob::create([
            'name' => CheckTimestamps::class,
            'agency_id' => $this->agency->id,
            'exception' => 'expiredRealtimeData',
            'snooze' => now()->addMinutes(30),
        ]);
        $this->sendNotification();
    }

    private function sendNotification()
    {
        Notification::send([User::first()], new RealtimeDataExpired($this->agency));
    }
}
