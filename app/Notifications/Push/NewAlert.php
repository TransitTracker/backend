<?php

namespace App\Notifications\Push;

use App\Models\Alert;
use App\Models\Region;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewAlert extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Alert $alert,
        private readonly ?Region $region = null
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function viaQueues()
    {
        return [
            WebPushChannel::class => 'notifications',
        ];
    }

    public function toWebPush()
    {
        $action = ['open_alert', $this->alert->id];
        if ($this->region) {
            $action[] = $this->region->slug;
        }

        $baseUrl = config('app.url');

        return (new WebPushMessage)
            ->icon("{$baseUrl}/img/icon-192.png")
            ->badge("{$baseUrl}/badge.png")
            ->title($this->alert->title)
            ->body($this->alert->subtitle)
            ->action(__('push.new_alert.action'), implode('.', $action));
    }
}
