<?php

namespace App\Mail;

use App\Agency;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\Events\JobFailed as EventJobFailed;
use Illuminate\Queue\SerializesModels;

class RefreshFailed extends Mailable
{
    use Queueable, SerializesModels;

    protected $exception;

    /**
     * @var string
     */
    protected string $agencySlug;

    /**
     * @var string
     */
    protected string $jobName;

    /**
     * Create a new message instance.
     *
     * @param $exception
     * @param string $agencySlug
     * @param string $jobName
     */
    public function __construct($exception, string $agencySlug, string $jobName)
    {
        $this->exception = $exception;
        $this->agencySlug = strtoupper($agencySlug);
        $this->jobName = $jobName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.failed.refresh')
                    ->subject('Refresh Failed for ' . $this->agencySlug)
                    ->with([
                        'jobName' => $this->jobName,
                        'agencySlug' => $this->agencySlug,
                        'jobException' => $this->exception->getMessage(),
                        'jobTrace' => $this->exception->getTraceAsString()
                    ]);
    }
}
