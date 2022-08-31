<?php

namespace App\Filament\Resources\AlertResource\Pages;

use App\Filament\Resources\AlertResource;
use App\Filament\Resources\AlertResource\Widgets\AlertsOverview;
use Filament\Resources\Pages\ListRecords;

class ListAlerts extends ListRecords
{
    protected static string $resource = AlertResource::class;

    public function getHeaderWidgets(): array
    {
        return [
            AlertsOverview::class,
        ];
    }
}
