<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;

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
                ViewColumn::make('label')->view('tables.columns.tag-preview'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->orderBy('type')),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                DetachBulkAction::make(),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }
}
