<?php

namespace App\Mail;

use App\FailedJob;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DispatchFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected string $exception;

    /**
     * @var string
     */
    protected string $agencySlug;

    /**
     * @var FailedJob
     */
    protected FailedJob $failedJob;

    /**
     * Create a new message instance.
     *
     * @param string $exception
     * @param string $agencySlug
     * @param FailedJob $failedJob
     */
    public function __construct(string $exception, string $agencySlug, FailedJob $failedJob)
    {
        $this->exception = $exception;
        $this->agencySlug = strtoupper($agencySlug);
        $this->failedJob = $failedJob;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.failed.dispatch')
                    ->subject('Dispatch Failed for '.$this->agencySlug)
                    ->with([
                        'agencySlug' => $this->agencySlug,
                        'responseString' => $this->exception,
                        'failedJob' => $this->failedJob,
                    ]);
    }
}
