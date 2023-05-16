<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Horizon extends Page
{
    protected static string $layout = 'filament.layout.iframe';

    protected static string $view = 'filament.pages.horizon';

    protected static ?string $navigationIcon = 'gmdi-cloud-queue-tt';

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
