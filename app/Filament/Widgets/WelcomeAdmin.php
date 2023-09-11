<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeAdmin extends Widget
{
    protected static string $view = 'filament.widgets.welcome-admin';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';
}
