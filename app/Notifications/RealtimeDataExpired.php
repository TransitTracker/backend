<?php

namespace App\Notifications;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class RealtimeDataExpired extends Notification
{
    use Queueable;

    public function __construct(private Agency $agency)
    {
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->warning()
            ->content("The realtime data for {$this->agency->short_name} has expired.")
            ->attachment(function (SlackAttachment $attachment) {
                $attachment->action('Open Horizon', route('horizon.index'));
            });
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function viaQueues()
    {
        return [
            'slack' => 'notifications',
        ];
    }
}
