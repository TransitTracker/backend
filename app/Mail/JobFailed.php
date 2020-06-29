<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
                        'jobTrace' => $this->exception->getTraceAsString(),
                    ]);
    }
}
