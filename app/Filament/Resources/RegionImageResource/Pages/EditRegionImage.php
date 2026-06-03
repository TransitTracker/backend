<?php

namespace App\Filament\Resources\RegionImageResource\Pages;

use App\Filament\Resources\RegionImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegionImage extends EditRecord
{
    protected static string $resource = RegionImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
