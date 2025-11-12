<?php

namespace App\Filament\Resources\AlertResource\Widgets;

use App\Enums\AlertStatus;
use App\Models\Alert;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlertStatusOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Count alerts by status
        $counts = Alert::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Build Stat cards using the enum values
        return collect(AlertStatus::cases())
            ->map(function (AlertStatus $status) use ($counts) {
                return Stat::make(
                    $status->getLabel(),
                    $counts[$status->value] ?? 0
                )
                    ->icon($status->getIcon())
                    ->color($status->getColor())
                    ->description($status->getDescription());
            })
            ->values()
            ->all();
    }
}
