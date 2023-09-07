<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ladder\Ladder;

class LadderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Ladder::role('vin-editor', 'exo VIN editor', [
            'vin:edit',
        ]);

        Ladder::role('zenbus-editor', 'Zenbus editor', [
            'zenbus:edit',
        ]);
    }
}
