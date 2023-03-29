<?php

namespace App\Providers;

use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        /* Vehicle::class => VehiclePolicy::class, */
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
