<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\Events\NotificationFailed;

class DeactivateInactiveSubscription
{
    public function __construct()
    {
    }

    public function handle(NotificationFailed $event)
    {
        Log::warning('notification user deactivated', ['uuid' => $event->subscription->subscribable->uuid]);

        $event->subscription->subscribable->is_active = false;
        $event->subscription->subscribable->save();
    }
}
