<?php

namespace App\Listeners;

use App\Events\NotificationUserCreated;
use App\Notifications\Push\Welcome;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeNotification implements ShouldQueue
{
    public $queue = 'notifications';

    public function __construct()
    {
    }

    public function handle(NotificationUserCreated $event)
    {
        $event->notificationUser->notify((new Welcome())->delay(now()->addMinute()));
    }
}
