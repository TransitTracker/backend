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
        // @phpstan-ignore-next-line
        Log::info('Push user has been deactivated', ['uuid' => $event->subscription->subscribable->uuid, 'reason' => $event->report->getReason()]);

        // @phpstan-ignore-next-line
        $event->subscription->subscribable->is_active = false;
        $event->subscription->subscribable->save();
    }
}
