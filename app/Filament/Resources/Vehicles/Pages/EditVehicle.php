<?php

namespace App\Filament\Resources\Vehicles\Pages;

use App\Filament\Resources\Vehicles\VehicleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to previous page, can be exo vin
        return $this->previousUrl ?? VehicleResource::getUrl();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('openInVin')
                ->url(route('vin.show', $this->record->ref))
                ->color('gray')
                ->label('Open in exo VIN')
                ->visible($this->record->isExoVin())
                ->openUrlInNewTab(),
            DeleteAction::make()->requiresConfirmation(),
        ];
    }
}
