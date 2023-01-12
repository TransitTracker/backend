<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('viewLogViewer', fn (?User $user) => in_array($user->email, [
            config('transittracker.admin_email'),
        ]));
    }
}
