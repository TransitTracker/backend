<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Resources\Pages\EditRecord;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to previous page, can be exo vin
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
