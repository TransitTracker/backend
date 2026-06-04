<?php

namespace App\Filament\Resources\CarriageResource\Pages;

use App\Filament\Resources\CarriageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCarriage extends EditRecord
{
    protected static string $resource = CarriageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
