<?php

namespace App\Filament\Resources\AlertResource\Pages;

use App\Filament\Resources\AlertResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;

class CreateAlert extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = AlertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
