<?php

namespace App\Filament\Resources\AlertResource\Pages;

use App\Filament\Resources\AlertResource;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;

class ListAlerts extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = AlertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
