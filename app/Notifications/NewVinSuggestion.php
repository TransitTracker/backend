<?php

namespace App\Notifications;

use App\Models\VinSuggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\SlackWebhookChannel;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewVinSuggestion extends Notification
{
    use Queueable;

    public function __construct(private VinSuggestion $vinSuggestion)
    {
    }

    public function via()
    {
        return [SlackWebhookChannel::class];
    }

    public function toSlack()
    {
        return (new SlackMessage)
            ->info()
            ->content("New VIN suggestion for {$this->vinSuggestion->vin}")
            ->attachment(function (SlackAttachment $attachment) {
                $attachment->action('View suggestion', route('vin.show', ['vin' => $this->vinSuggestion->vin]));
            });
    }

    public function viaQueues()
    {
        return [
            'slack' => 'notifications',
        ];
    }
}
