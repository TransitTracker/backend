<?php

namespace App\Filament\Resources\AlertResource\Widgets;

use App\Models\Alert;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AlertsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Active alerts', Alert::active()->count()),
        ];
    }
}
