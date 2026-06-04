<?php

namespace App\Filament\Resources\CarriageTypeResource\Pages;

use App\Filament\Resources\CarriageTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCarriageTypes extends ManageRecords
{
    protected static string $resource = CarriageTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
