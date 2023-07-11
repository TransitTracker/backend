<?php

namespace App\Http\Livewire;

use App\Models\Vehicle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class OperatorTable extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return Vehicle::query()->exoWithVin();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('ref'),
            TextColumn::make('force_label'),
            TextColumn::make('gtfsRoute.short_name'),
            TextColumn::make('updated_at'),
        ];
    }

    public function render()
    {
        return view('livewire.operator-table');
    }
}
