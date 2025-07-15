<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TagsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'label';

    protected function getTableDescription(): string|Htmlable|null
    {
        return 'There is currently a bug when adding a label. The search does not work and both translations are displayed.';
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('label')->view('tables.columns.tag-preview'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->orderBy('type')),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }
}
