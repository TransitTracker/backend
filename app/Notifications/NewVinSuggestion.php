<?php

namespace App\Notifications;

use App\Models\Vin\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\SlackWebhookChannel;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewVinSuggestion extends Notification
{
    use Queueable;

    public function __construct(private Suggestion $suggestion)
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
            ->content("New VIN suggestion for {$this->suggestion->vin}")
            ->attachment(function (SlackAttachment $attachment) {
                $attachment->action('View suggestion', route('vin.show', ['vin' => $this->suggestion->vin]));
            });
    }

    public function viaQueues()
    {
        return [
            'slack' => 'notifications',
        ];
    }
}
