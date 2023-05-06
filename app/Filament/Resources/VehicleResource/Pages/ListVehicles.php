<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Enums\TagType;
use App\Enums\VehicleType;
use App\Filament\Resources\VehicleResource;
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

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('changeType')
                ->action(function (Collection $records, array $data): void {
                    foreach ($records as $record) {
                        $record->vehicle_type = $data['vehicle_type'];
                        $record->saveQuietly();
                    }
                })
                ->form([
                    Select::make('vehicle_type')->options(VehicleType::asFlippedArray())->required(),
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
            Filter::make('onlyExoVin')->query(fn (Builder $query): Builder => $query->exoWithVin())->toggle()->default(),
            Filter::make('withoutOperators')
                ->query(fn (Builder $query): Builder => $query->withoutTypeOfTags(TagType::Operator))
                ->toggle()
                ->default(),
            Filter::make('onlyZenbus')
                ->label('Only Zenbus')
                ->query(fn (Builder $query): Builder => $query->where('vehicle_id', 'LIKE', 'zenbus:Vehicle:%'))
                ->toggle(),
            SelectFilter::make('agency')->relationship('agency', 'short_name'),
            Filter::make('refStartsWith')->form([
                TextInput::make('refStartsWith'),
            ])->query(function (Builder $query, array $data): Builder {
                if (! $data['refStartsWith']) {
                    return $query;
                }

                return $query->where('vehicle_id', 'LIKE', "{$data['refStartsWith']}%");
            }),
            Filter::make('forceLabelStartsWith')->form([
                TextInput::make('forceLabelStartsWith'),
            ])->query(function (Builder $query, array $data): Builder {
                if (! $data['forceLabelStartsWith']) {
                    return $query;
                }

                return $query->where('force_label', 'LIKE', "{$data['forceLabelStartsWith']}%");
            }),
        ];
    }
}
