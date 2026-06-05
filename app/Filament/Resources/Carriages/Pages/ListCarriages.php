<?php

namespace App\Filament\Resources\Carriages\Pages;

use App\Filament\Resources\Carriages\CarriageResource;
use Filament\Resources\Pages\ListRecords;

class ListCarriages extends ListRecords
{
    protected static string $resource = CarriageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
