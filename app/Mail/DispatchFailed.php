<?php

namespace App\Mail;

use GuzzleHttp\Psr7;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Throwable;

class DispatchFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Throwable
     */
    protected Throwable $exception;

    /**
     * @var string
     */
    protected string $agencySlug;

    /**
     * Create a new message instance.
     *
     * @param Throwable $exception
     * @param string $agencySlug
     */
    public function __construct(Throwable $exception, string $agencySlug)
    {
        $this->exception = $exception;
        $this->agencySlug = strtoupper($agencySlug);
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
                        'responseString' => Psr7\str($this->exception->getResponse()),
                    ]);
    }
}
