<?php

namespace App\Filament\Resources\CarriageTypeResource\Pages;

use App\Filament\Resources\CarriageTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCarriageTypes extends ManageRecords
{
    protected static string $resource = CarriageTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
