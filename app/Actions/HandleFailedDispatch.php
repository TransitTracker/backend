<?php

namespace App\Actions;

use App\Models\Agency;
use App\Models\FailedJob;
use App\Mail\DispatchFailed;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
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
            $smallException = mb_substr((string) $this->exception->getResponse()->getStatusCode().Psr7\str($this->exception->getRequest()), 0, 250);
        } else {
            $smallException = mb_substr(Psr7\str($this->exception->getRequest()), 0, 250);
        }

        $failedJob = FailedJob::firstWhere([
            'name' => 'App\\Jobs\\DispatchAgencies',
            'agency_id' => $this->agency->id,
            'exception' => $smallException,
        ]);

        if ($failedJob && Carbon::parse($failedJob->snooze)->isAfter($thirty)) {
            // Do nothing
            info('Nothing to do. Failed job is in the snooze period for at least 30 minutes.');
        } elseif ($failedJob && Carbon::parse($failedJob->snooze)->isAfter($now)) {
            info('Do not send, but add 30 minutes to the snooze period.');
            // Update but do not send
            $failedJob->snooze = $thirty;
            $failedJob->save();
        } elseif ($failedJob) {
            info('Send, snooze period is expired');
            // Update and send
            $failedJob->snooze = $thirty;
            $failedJob->save();
            $this->sendNotification($failedJob);
        } else {
            $failedJob = FailedJob::create([
                'name' => 'App\\Jobs\\DispatchAgencies',
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
        Mail::to(env('MAIL_TO'))->send(new DispatchFailed(Psr7\str($exception), $this->agency->slug, $failedJob));
    }
}
