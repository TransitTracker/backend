<?php

namespace App\Notifications\Push;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class Welcome extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
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
            ->title(__('push.welcome.title', []))
            ->body(__('push.welcome.body', []));
    }

    public function toArray()
    {
        return [
            'title' => __('push.welcome.title', []),
            'body' => __('push.welcome.body', []),
        ];
    }
}
