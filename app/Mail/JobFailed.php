<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The error (Exception)
     *
     * @var Exception
     */
    public $exception;

    /**
     * The agency
     *
     * @var String
     */
    public $agency;

    /**
     * Create a new message instance.
     *
     * @param Exception $exception
     * @param String $agency
     * @return void
     */
    public function __construct(Exception $exception, String $agency)
    {
        $this->exception = $exception;
        $this->agency = $agency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM', 'app@example.com'))
                    ->view('emails.jobfailed');
    }
}
