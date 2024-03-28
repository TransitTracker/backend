<?php

namespace App\Notifications\Push;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdatedVehicle extends Notification implements ShouldQueue
{
    use Queueable;

    private string $emoji;

    public function __construct(private Vehicle $vehicle)
    {
        $this->vehicle->load(['gtfsRoute:agency_id,gtfs_route_id,short_name', 'agency:id', 'agency.regions:slug']);

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
            ->title(__('push.updated_vehicle.title', ['label' => $this->vehicle->displayed_label, 'route' => $this->vehicle->gtfsRoute->short_name ?? $this->vehicle->gtfs_route_id, 'emoji' => $this->emoji]))
            ->body(__('push.updated_vehicle.body', ['label' => $this->vehicle->displayed_label]))
            ->action(__('push.updated_vehicle.action_track', []), "open_vehicle.{$this->vehicle->agency->regions[0]->slug}.{$this->vehicle->id}")
            ->data(['vehicle_id' => $this->vehicle->id]);
    }

    public function toArray()
    {
        return [
            'title' => __('push.updated_vehicle.title', ['label' => $this->vehicle->displayed_label, 'route' => $this->vehicle->gtfsRoute->short_name ?? $this->vehicle->gtfs_route_id, 'emoji' => $this->emoji]),
            'body' => __('push.updated_vehicle.body', ['label' => $this->vehicle->displayed_label]),
        ];
    }
}
