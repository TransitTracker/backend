<?php

namespace App\Listeners;

use App\Events\VehicleUpdated;
use App\Notifications\Push\UpdatedVehicle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendUpdatedVehicleNotification
{
    public $queue = 'notifications';

    public function __construct()
    {
    }

    public function handle(VehicleUpdated $event)
    {
        $event->vehicle->load('notificationUsers');

        Notification::send($event->vehicle->notification_users, new UpdatedVehicle($event->vehicle));
    }
}
