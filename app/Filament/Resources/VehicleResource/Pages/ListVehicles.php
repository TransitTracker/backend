<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use App\Filament\Resources\VehicleResource\Widgets\VehiclesChart;
use App\Models\Link;
use App\Models\Tag;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('changeIcon')
                ->action(function (Collection $records, array $data): void {
                    foreach ($records as $record) {
                        $record->icon = $data['icon'];
                        $record->saveQuietly();
                    }
                })
                ->form([
                    Select::make('icon')->options(['bus' => 'Bus', 'train' => 'Train', 'tram' => 'Tram', 'bus-electric' => 'Electric bus'])->required(),
                ])->icon('gmdi-switch-access-shortcut'),
            BulkAction::make('attachLink')
                ->action(function (Collection $records, array $data): void {
                    foreach ($records as $record) {
                        $record->links()->attach($data['linkId']);
                        $record->saveQuietly();
                    }
                })
                ->form([
                    Select::make('linkId')->options(Link::pluck('internal_title', 'id'))->label('Link')->required(),
                ])->icon('gmdi-link'),
            BulkAction::make('attachTag')
                ->action(function (Collection $records, array $data): void {
                    foreach ($records as $record) {
                        $record->tags()->attach($data['tagId']);
                        $record->saveQuietly();
                    }
                })
                ->form([
                    Select::make('tagId')->options(Tag::pluck('label', 'id'))->label('Tag')->required(),
                ])->icon('gmdi-label'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('agency')->relationship('agency', 'short_name'),
            Filter::make('refStartsWith')->form([
                TextInput::make('refStartsWith'),
            ])->query(function (Builder $query, array $data): Builder {
                return $query->where('vehicle', 'LIKE', "{$data['refStartsWith']}%");
            }),
        ];
    }
}
