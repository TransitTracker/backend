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
        Log::info('Push user has been deactivated', ['uuid' => $event->subscription->subscribable->uuid, 'reason' => $event->report->getReason()]);

        $event->subscription->subscribable->is_active = false;
        $event->subscription->subscribable->save();
    }
}
