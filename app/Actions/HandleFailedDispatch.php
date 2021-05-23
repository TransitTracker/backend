<?php

namespace App\Actions;

use App\Mail\DispatchFailed;
use App\Models\Agency;
use App\Models\FailedJob;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Mail;

class HandleFailedDispatch
{
    private RequestException $exception;
    private Agency $agency;

    public function __construct(RequestException $exception, Agency $agency)
    {
        $this->exception = $exception;
        $this->agency = $agency;
    }

    public function execute()
    {
        $now = now();
        $thirty = now()->addMinutes(30);

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

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter($thirty)) {
            // Do nothing
        } elseif ($failedJob && Carbon::parse($failedJob->snooze)->isAfter($now)) {
            // Update but do not send
            $failedJob->snooze = $thirty;
            $failedJob->save();
        } elseif ($failedJob) {
            // Update and send
            $failedJob->snooze = $thirty;
            $failedJob->save();
            $this->sendNotification($failedJob);
        } else {
            $failedJob = FailedJob::create([
                'name' => 'App\\Jobs\\RealtimeData\\DispatchAgencies',
                'agency_id' => $this->agency->id,
                'exception' => $smallException,
                'snooze' => $thirty,
            ]);
            $this->sendNotification($failedJob);
        }
    }

    private function sendNotification(FailedJob $failedJob)
    {
        $exception = $this->exception->hasResponse() ? $this->exception->getResponse() : $this->exception->getRequest();
        Mail::to(config('transittracker.admin_email'))->send(new DispatchFailed(Psr7\str($exception), $this->agency->slug, $failedJob));
    }
}
