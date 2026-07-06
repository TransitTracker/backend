<?php

namespace App\Providers;

use App;
use BenSampo\Enum\Enum;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Whitecube\LaravelCookieConsent\Facades\Cookies;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Model::preventLazyLoading(App::environment('local'));

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Enum::macro('asFlippedArray', function () {
            return array_flip(self::asArray());
        });

        FilamentIcon::register([
            'panels::pages.dashboard.navigation-item' => 'gmdi-home-tt',
        ]);

        Cookies::essentials()
            ->session()
            ->csrf();
    }
}
