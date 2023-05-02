<?php

namespace App\Filament\Widgets;

use App\Enums\TagType;
use App\Models\Tag;
use App\Models\Vehicle;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class VehiclesWithoutOperators extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Vehicle::query()
            ->exoWithVin()
            ->withoutTypeOfTags(TagType::Operator)
            ->select(['id', 'vehicle_id', 'force_label', 'label', 'agency_id'])
            ->with('agency:id,short_name');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('agency.short_name')->label('Agency'),
            TextColumn::make('displayed_label')->label('Label'),
            TextColumn::make('ref'),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
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

    protected function getTableActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
