<?php

namespace App\Listeners;

use App\Events\VinSuggestionCreated;
use App\Models\User;
use App\Notifications\NewVinSuggestion;
use Illuminate\Support\Facades\Notification;

class SendNewVinSuggestionNotification
{
    public function __construct()
    {
    }

    public function handle(VinSuggestionCreated $event)
    {
        Notification::send(User::first(), new NewVinSuggestion($event->vinSuggestion));
    }
}
