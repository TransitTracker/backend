<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Events\JobFailed as EventJobFailed;

class JobFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected string $className;

    protected $exception;

    /**
     * Create a new message instance.
     *
     * @param string $className
     * @param $exception
     */
    public function __construct(string $className, $exception)
    {
        $this->className = $className;
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.failed.job')
                    ->with([
                        'jobName' => $this->className,
                        'jobException' => $this->exception->getMessage(),
                        'jobTrace' => $this->exception->getTraceAsString()
                    ]);
    }
}
