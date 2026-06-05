<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RegionImageSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $regionImages;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $regionImages)
    {
        $this->regionImages = $regionImages;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $firstImage = $this->regionImages->first();

        return new Envelope(
            subject: "New Region Images Submitted: {$firstImage->region->name}",
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($firstImage->author_email, $firstImage->author_name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.region-image-submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
