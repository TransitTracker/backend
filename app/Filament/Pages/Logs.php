<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Logs extends Page
{
    protected static string $layout = 'filament.layout.iframe';

    protected static string $view = 'filament.pages.logs';

    protected static ?string $navigationIcon = 'gmdi-error-tt';

    protected static ?string $navigationGroup = 'System';

    protected ?string $heading = '';

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
    }
}
