<?php

namespace App\Notifications\Push;

use App\Models\NotificationUser;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ElectricStmAppearance extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Vehicle $vehicle)
    {
    }

    public function via()
    {
        return [WebPushChannel::class];
    }

    public function viaQueues()
    {
        return [
            WebPushChannel::class => 'notifications',
        ];
    }

    public function toWebPush(NotificationUser $notifiable)
    {
        $this->vehicle->load('trip');

        $locale = $notifiable->is_french ? 'fr' : 'en';

        return (new WebPushMessage)
            ->icon('https://api.transittracker.ca/img/icon-192.png')
            ->badge('https://api.transittracker.ca/img/badge.png')
            ->title(__('push.electric_stm.title', ['label' => $this->vehicle->vehicle, 'headsign' => $this->vehicle->trip->trip_headsign], $locale))
            ->body(__('push.electric_stm.body', ['label' => $this->vehicle->vehicle, 'route' => "{$this->vehicle->trip->route_short_name} {$this->vehicle->trip->route_long_name}"], $locale))
            ->action(__('push.electric_stm.action_track', [], $locale), "open_region.{$this->vehicle->agency->regions[0]->slug}")
            ->action(__('push.electric_stm.action_gtfstools', [], $locale), "open_gtfstools.{$this->vehicle->gtfs_trip}");
    }
}
