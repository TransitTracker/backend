<?php

namespace App\Listeners;

use App\Events\VehicleCreated;
use App\Models\Vehicle;
use App\Notifications\Push\NewVehicle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewVehicleNotification implements ShouldQueue
{
    public $queue = 'notifications';

    public function __construct()
    {
    }

    public function handle(VehicleCreated $event)
    {
        $event->vehicle->load(['agency.activeNotificationUsers', 'agency.regions:id,slug']);
        Notification::send($event->vehicle->agency->activeNotificationUsers, new NewVehicle($event->vehicle));
    }
}
