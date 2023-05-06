<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Horizon extends Page
{
    protected static string $layout = 'filament.layout.iframe';

    protected static string $view = 'filament.pages.horizon';

    protected static ?string $navigationIcon = 'gmdi-cloud-queue';

    protected static ?string $navigationGroup = 'System';

    protected static bool $shouldRegisterNavigation = false;

    protected ?string $heading = '';
}
