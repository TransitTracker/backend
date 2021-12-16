<?php

namespace App\Notifications\Push;

use App\Models\NotificationUser;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewVehicle extends Notification implements ShouldQueue
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
        $locale = $notifiable->is_french ? 'fr' : 'en';
        $label = $this->vehicle->force_label ?? $this->vehicle->label ?? $this->vehicle->vehicle;

        $emoji = '🚌';
        if ($this->vehicle->icon === 'train') {
            $emoji = '🚆';
        } elseif ($this->vehicle->icon === 'tram') {
            $emoji = '🚊';
        }

        return (new WebPushMessage)
            ->icon('https://www.transittracker.ca/icon.png')
            ->badge('https://www.transittracker.ca/badge.png')
            ->title(__('push.new_vehicle.title', ['emoji' => $emoji, 'type' => $this->vehicle->icon, 'label' => $label, 'agency' => $this->vehicle->agency->short_name], $locale))
            ->body(__('push.new_vehicle.body', ['label' => $label, 'route' => $this->vehicle->trip->route_short_name ?? $this->vehicle->route], $locale))
            ->action(__('push.new_vehicle.action', [], $locale), "open_region.{$this->vehicle->agency->regions[0]->slug}");
    }
}
