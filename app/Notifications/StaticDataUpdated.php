<?php

namespace App\Notifications;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class StaticDataUpdated extends Notification
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
        $agency = $this->agency->loadCount(['trips', 'routes', 'services']);

        return (new SlackMessage)
            ->success()
            ->from('DownloadStatic')
            ->content("Successfully updated static GTFS data of *{$this->agency->short_name}*")
            ->attachment(function (SlackAttachment $attachment) use ($agency) {
                $attachment->fields([
                    'Trips' => $agency->trips_count,
                    'Routes' => $agency->routes_count,
                    'Services' => $agency->services_count,
                ]);
            });
    }

    public function viaQueues()
    {
        return [
            'slack' => 'notifications',
        ];
    }
}
