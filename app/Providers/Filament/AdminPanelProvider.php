<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Rmsramos\Activitylog\ActivitylogPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path(config('transittracker.path.filament', 'admin'))
            ->domain(config('transittracker.domain.filament', null))
            ->login()
            ->profile()
            ->colors([
                'primary' => '#2374ab',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationItems([
                NavigationItem::make('exo VIN')
                    ->url(fn (): string => route('vin.index'), shouldOpenInNewTab: true)
                    ->icon('gmdi-directions-bus-tt')
                    ->group('External'),
                NavigationItem::make('Horizon')
                    ->url(fn (): string => route('horizon.index'), shouldOpenInNewTab: true)
                    ->icon('gmdi-cloud-queue-tt')
                    ->group('System')
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
                NavigationItem::make('Logs')
                    ->url(fn (): string => route('log-viewer.index'), shouldOpenInNewTab: true)
                    ->icon('gmdi-error-tt')
                    ->group('System')
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
            ])
            ->collapsibleNavigationGroups(false)
            ->plugins([
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['en', 'fr']),
                EnvironmentIndicatorPlugin::make()
                    // Only super admin can see everything, so even if the permissions does not exist it's still ok!
                    ->visible(fn () => auth()->user()?->can('see_indicator'))
                    ->showBorder(true)
                    ->showBadge(true)
                    ->color(fn () => match (app()->environment()) {
                        'production' => Color::Red,
                        'local' => Color::Blue,
                        default => Color::Pink,
                    }),
                ActivitylogPlugin::make()
                    ->navigationGroup('System')
                    ->navigationIcon('gmdi-fact-check-tt')
                    ->authorize(fn (): bool  => auth()->user()->isAdmin()),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
