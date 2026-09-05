<?php

namespace App\Filament\Resources\Vehicles\Pages;

use App\Filament\Resources\Vehicles\VehicleResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'vin' => Tab::make('Only exo VIN')
                ->modifyQueryUsing(fn (Builder $query) => $query->exoWithVin()),
            'zenbus' => Tab::make('Only Zenbus')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('vehicle_id', 'LIKE', 'zenbus:Vehicle:%')),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        $permissions = auth()->user()->permissions()->unique()->values()->all();

        if ($permissions === ['vin:edit']) {
            return 'vin';
        } elseif ($permissions === ['zenbus:edit']) {
            return 'zenbus';
        } else {
            return 'all';
        }
    }
}
