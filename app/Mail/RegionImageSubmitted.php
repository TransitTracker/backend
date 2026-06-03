<?php

namespace App\Mail;

use App\Models\RegionImage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegionImageSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public RegionImage $regionImage;

    /**
     * Create a new message instance.
     */
    public function __construct(RegionImage $regionImage)
    {
        $this->regionImage = $regionImage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Region Image Submitted: {$this->regionImage->region->name}",
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
