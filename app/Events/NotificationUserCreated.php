<?php

namespace App\Events;

use App\Models\NotificationUser;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationUserCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public NotificationUser $notificationUser)
    {
    }
}
