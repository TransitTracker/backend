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
            ->title(__('push.new_vehicle.title', ['emoji' => $this->emoji, 'type' => $this->vehicle->vehicle_type->description, 'label' => $this->vehicle->displayed_label, 'agency' => $this->vehicle->agency->short_name]))
            ->body(__('push.new_vehicle.body', ['label' => $this->vehicle->displayed_label, 'route' => $this->vehicle->gtfsRoute->short_name ?? $this->vehicle->gtfs_route_id]))
            ->action(__('push.new_vehicle.action', []), "open_vehicle.{$this->vehicle->agency->regions[0]->slug}.{$this->vehicle->id}");
    }

    public function toArray()
    {
        return [
            'title' => __('push.new_vehicle.title', ['emoji' => $this->emoji, 'type' => $this->vehicle->vehicle_type->description, 'label' => $this->label, 'agency' => $this->vehicle->agency->short_name]),
            'body' => __('push.new_vehicle.body', ['label' => $this->vehicle->displayed_label, 'route' => $this->vehicle->gtfsRoute->short_name ?? $this->vehicle->gtfs_route_id]),
        ];
    }
}
