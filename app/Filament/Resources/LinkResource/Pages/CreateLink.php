<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;

class CreateLink extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
