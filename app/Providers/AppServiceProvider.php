<?php

namespace App\Providers;

use App;
use BenSampo\Enum\Enum;
use Dedoc\Scramble\Scramble;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use Whitecube\LaravelCookieConsent\Facades\Cookies;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Model::preventLazyLoading(App::environment('local'));

        Health::checks([
            CacheCheck::new(),
            CpuLoadCheck::new()->failWhenLoadIsHigherInTheLast5Minutes(0.75),
            DatabaseCheck::new(),
            DatabaseConnectionCountCheck::new()->warnWhenMoreConnectionsThan(25)->failWhenMoreConnectionsThan(50),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            HorizonCheck::new(),
            RedisCheck::new(),
            SecurityAdvisoriesCheck::new(),
            UsedDiskSpaceCheck::new(),
        ]);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Enum::macro('asFlippedArray', function () {
            return array_flip(self::asArray());
        });

        Cookies::essentials()
            ->session()
            ->csrf();

        $link = config('transittracker.domain.api');
        Http::globalRequestMiddleware(fn ($request) => $request->withHeader(
            'User-Agent', "TransitTrackerBackend/2.0; +{$link}",
        ));

        // Filament custom
        FilamentIcon::register([
            'panels::pages.dashboard.navigation-item' => 'gmdi-home-tt',
        ]);
        FilamentAsset::register([
            Js::make('leaflet', resource_path('js/leaflet.js'))->loadedOnRequest(),
            Js::make('terra-draw', resource_path('js/terra-draw.js'))->loadedOnRequest(),
            Css::make('leaflet', resource_path('css/leaflet.css'))->loadedOnRequest(),
        ]);
    }
}
