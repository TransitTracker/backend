<?php

namespace App\Providers;

use App\Models\Agency;
use App\Models\Tag;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->domain(config('transittracker.domain.vin'))
                ->prefix(config('transittracker.path.vin'))
                ->namespace($this->namespace)
                ->group(base_path('routes/vin.php'));

            Route::prefix('')
                ->domain(config('transittracker.domain.api'))
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->domain(config('transittracker.domain.web'))
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->domain(config('filament.domain'))
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));
        });

        Route::bind('agencySlug', function (string $value) {
            return Agency::select(['id', 'slug'])->where('slug', $value)->firstOrFail();
        });

        Route::bind('tagSlug', function (string $value) {
            return Tag::where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
