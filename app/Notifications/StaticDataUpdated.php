<?php

namespace App\Notifications;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
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
        $agency = $this->agency->loadCount(['routes', 'services', 'trips', 'shapes', 'stops', 'stopTimes']);

        return (new SlackMessage)
            ->success()
            ->from('DownloadStatic')
            ->content("Successfully updated static GTFS data of *{$this->agency->short_name}*")
            ->attachment(function (SlackAttachment $attachment) use ($agency) {
                $attachment->fields([
                    'Routes' => $agency->routes_count,
                    'Services' => $agency->services_count,
                    'Trips' => $agency->trips_count,
                    'Shapes' => $agency->shapes_count,
                    'Stops' => $agency->stops_count,
                    'StopTimes' => $agency->stop_times_count,
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
