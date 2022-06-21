<?php

namespace App\Providers;

use App\Events\ElectricStmVehicleUpdated;
use App\Events\NotificationUserCreated;
use App\Events\VehicleCreated;
use App\Events\VinSuggestionCreated;
use App\Listeners\DeactivateInactiveSubscription;
use App\Listeners\SendElectricStmNotification;
use App\Listeners\SendNewVehicleNotification;
use App\Listeners\SendNewVinSuggestionNotification;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use NotificationChannels\WebPush\Events\NotificationFailed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotificationFailed::class => [
            DeactivateInactiveSubscription::class,
        ],
        NotificationUserCreated::class => [
            SendWelcomeNotification::class,
        ],
        VehicleCreated::class => [
            SendNewVehicleNotification::class,
        ],
        ElectricStmVehicleUpdated::class => [
            SendElectricStmNotification::class,
        ],
        VinSuggestionCreated::class => [
            SendNewVinSuggestionNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
