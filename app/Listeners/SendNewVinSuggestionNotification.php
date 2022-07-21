<?php

namespace App\Listeners;

use App\Events\Vin\SuggestionCreated;
use App\Models\User;
use App\Notifications\NewVinSuggestion;
use Illuminate\Support\Facades\Notification;

class SendNewVinSuggestionNotification
{
    public function __construct()
    {
    }

    public function handle(SuggestionCreated $event)
    {
        Notification::send(User::first(), new NewVinSuggestion($event->suggestion));
    }
}
