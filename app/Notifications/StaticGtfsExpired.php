<?php

namespace App\Notifications;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class StaticGtfsExpired extends Notification
{
    use Queueable;

    private Agency $agency;

    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $url = $this->agency->signedUpdateGtfsUrl();

        return (new SlackMessage)
            ->warning()
            ->content("The GTFS data for {$this->agency->short_name} might be expired.")
            ->attachment(function (SlackAttachment $attachment) use ($url) {
                $attachment->action('Update static data', $url);
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
