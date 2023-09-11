<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    public function getTabs(): array
    {
        return [
            'all' => ListRecords\Tab::make(),
            'vin' => ListRecords\Tab::make('Only exo VIN')
                ->modifyQueryUsing(fn (Builder $query) => $query->exoWithVin()),
            'zenbus' => ListRecords\Tab::make('Only Zenbus')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('vehicle_id', 'LIKE', 'zenbus:Vehicle:%')),
        ];
    }
}
