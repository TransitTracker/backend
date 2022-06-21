<?php

namespace App\Listeners;

use App\Events\ElectricStmVehicleUpdated;
use App\Events\VehicleUpdated;
use App\Models\NotificationUser;
use App\Notifications\Push\UpdatedVehicle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendUpdatedVehicleNotification implements ShouldQueue
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
