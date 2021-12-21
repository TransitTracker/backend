<?php

namespace App\Listeners;

use App\Events\ElectricStmVehicleUpdated;
use App\Models\NotificationUser;
use App\Notifications\Push\ElectricStmAppearance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendElectricStmNotification implements ShouldQueue
{
    public $queue = 'notifications';

    public function __construct()
    {
    }

    public function handle(ElectricStmVehicleUpdated $event)
    {
        $users = NotificationUser::query()
            ->where([
                'is_active' => true,
                'subscribed_electric_stm' => true,
            ])
            ->get();

        Notification::send($users, new ElectricStmAppearance($event->vehicle));
    }
}
