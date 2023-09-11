<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
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
