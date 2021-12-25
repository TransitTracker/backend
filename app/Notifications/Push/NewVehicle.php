<?php

namespace App\Notifications\Push;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewVehicle extends Notification implements ShouldQueue
{
    use Queueable;

    private string $label;
    private string $emoji;

    public function __construct(private Vehicle $vehicle)
    {
        $this->label = $vehicle->force_label ?? $vehicle->label ?? $vehicle->vehicle;

        $emoji = '🚌';
        if ($vehicle->icon === 'train') {
            $emoji = '🚆';
        } elseif ($vehicle->icon === 'tram') {
            $emoji = '🚊';
        }

        $this->emoji = $emoji;
    }

    public function via()
    {
        return [WebPushChannel::class, DatabaseChannel::class];
    }

    public function viaQueues()
    {
        return [
            WebPushChannel::class => 'notifications',
        ];
    }

    public function toWebPush()
    {
        return (new WebPushMessage)
            ->icon('https://api.transittracker.ca/img/icon-192.png')
            ->badge('https://api.transittracker.ca/img/badge.png')
            ->title(__('push.new_vehicle.title', ['emoji' => $this->emoji, 'type' => $this->vehicle->icon, 'label' => $this->label, 'agency' => $this->vehicle->agency->short_name]))
            ->body(__('push.new_vehicle.body', ['label' => $this->label, 'route' => $this->vehicle->trip->route_short_name ?? $this->vehicle->route]))
            ->action(__('push.new_vehicle.action', []), "open_region.{$this->vehicle->agency->regions[0]->slug}");
    }

    public function toArray()
    {
        return [
            'title' => __('push.new_vehicle.title', ['emoji' => $this->emoji, 'type' => $this->vehicle->icon, 'label' => $this->label, 'agency' => $this->vehicle->agency->short_name]),
            'body' => __('push.new_vehicle.body', ['label' => $this->label, 'route' => $this->vehicle->trip->route_short_name ?? $this->vehicle->route]),
        ];
    }
}
