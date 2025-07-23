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

    public function getDefaultActiveTab(): string|int|null
    {
        $permissions = auth()->user()->permissions()->unique()->values()->all();

        if ($permissions === ['vin:edit']) {
            return 'vin';
        } else if ($permissions === ['zenbus:edit']) {
            return 'zenbus';
        } else {
            return 'all';
        }
    }
}
