<?php

namespace App\Providers;

use App\Events\ElectricStmVehicleUpdated;
use App\Events\NotificationUserCreated;
use App\Events\TagCreated;
use App\Events\TagUpdated;
use App\Events\VehicleCreated;
use App\Events\VehicleForceRefAdded;
use App\Events\VehicleUpdated;
use App\Events\Vin\SuggestionCreated;
use App\Listeners\AddTagIconToMapbox;
use App\Listeners\DeactivateInactiveSubscription;
use App\Listeners\DecodeVin;
use App\Listeners\SendElectricStmNotification;
use App\Listeners\SendNewVehicleNotification;
use App\Listeners\SendNewVinSuggestionNotification;
use App\Listeners\SendUpdatedVehicleNotification;
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
            //            SendNewVehicleNotification::class,
            DecodeVin::class,
        ],
        VehicleUpdated::class => [
            SendUpdatedVehicleNotification::class,
        ],
        VehicleForceRefAdded::class => [
            DecodeVin::class,
        ],
        ElectricStmVehicleUpdated::class => [
            SendElectricStmNotification::class,
        ],
        SuggestionCreated::class => [
            SendNewVinSuggestionNotification::class,
        ],
        TagCreated::class => [
            AddTagIconToMapbox::class,
        ],
        TagUpdated::class => [
            AddTagIconToMapbox::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
