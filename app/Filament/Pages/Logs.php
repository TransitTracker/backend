<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Logs extends Page
{
    protected static string $layout = 'filament.layout.iframe';

    protected static string $view = 'filament.pages.logs';

    protected static ?string $navigationIcon = 'gmdi-text-snippet';

    protected static ?string $navigationGroup = 'System';

    protected static bool $shouldRegisterNavigation = false;

    protected ?string $heading = '';
}
