<?php

namespace App\Providers;

use App;
use BenSampo\Enum\Enum;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
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

        Filament::serving(function () {
            $navigationItems = [
                NavigationItem::make('exo VIN')
                    ->url(route('vin.index'))
                    ->icon('gmdi-directions-bus')
                    ->group('Special'),
            ];

            if (Auth::hasUser() && Auth::user()->isAdmin()) {
                array_push($navigationItems,
                    NavigationItem::make('Logs')
                        ->url(route('log-viewer.index'))
                        ->icon('gmdi-error')
                        ->group('System'),
                    NavigationItem::make('Horizon')
                        ->url(route('horizon.index'))
                        ->icon('gmdi-cloud-queue')
                        ->group('System'));
            }

            Filament::registerNavigationItems($navigationItems);
        });

        LogViewer::auth(function (Request $request) {
            return $request->user()
                && $request->user()->isAdmin();
        });
    }
}
