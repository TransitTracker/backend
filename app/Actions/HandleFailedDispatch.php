<?php

namespace App\Actions;

use App\Models\Agency;
use App\Models\FailedJob;
use App\Models\User;
use App\Notifications\DispatchFailed;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Notification;

class HandleFailedDispatch
{
    public function __construct(private RequestException $exception, private Agency $agency)
    {
    }

    public function execute()
    {
        if ($this->exception->hasResponse()) {
            $smallException = mb_substr((string) $this->exception->getResponse()->getStatusCode().Message::toString($this->exception->getRequest()), 0, 250);
        } else {
            $smallException = mb_substr(Message::toString($this->exception->getRequest()), 0, 250);
        }

        $failedJob = FailedJob::firstWhere([
            'name' => 'App\\Jobs\\RealtimeData\\DispatchAgencies',
            'agency_id' => $this->agency->id,
            'exception' => $smallException,
        ]);

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now()->addMinutes(30))) {
            // Do nothing
        } elseif ($failedJob && Carbon::parse($failedJob->snooze)->isAfter(now())) {
            // Update but do not send
            $failedJob->snooze = now()->addMinutes(30);
            $failedJob->save();
        } elseif ($failedJob) {
            // Update and send
            $failedJob->snooze = now()->addMinutes(30);
            $failedJob->save();
            $this->sendNotification($failedJob);
        } else {
            $failedJob = FailedJob::create([
                'name' => 'App\\Jobs\\RealtimeData\\DispatchAgencies',
                'agency_id' => $this->agency->id,
                'exception' => $smallException,
                'snooze' => now()->addMinutes(30),
            ]);
            $this->sendNotification($failedJob);
        }
    }

    private function sendNotification(FailedJob $failedJob)
    {
        Notification::send([User::first()], new DispatchFailed($failedJob));
    }
}
