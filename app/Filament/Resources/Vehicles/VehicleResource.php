<?php

namespace App\Filament\Resources\Vehicles;

use AlizHarb\ActivityLog\RelationManagers\ActivitiesRelationManager;
use App\Enums\TagType;
use App\Enums\VehicleType;
use App\Filament\Resources\Vehicles\Pages\EditVehicle;
use App\Filament\Resources\Vehicles\Pages\ListVehicles;
use App\Filament\Resources\Vehicles\RelationManagers\TagsRelationManager;
use App\Models\Link;
use App\Models\Tag;
use App\Models\Vehicle;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-directions-bus-tt';

    protected static ?string $recordTitleAttribute = 'vehicle_id';

    public static function getGloballySearchableAttributes(): array
    {
        return ['vehicle_id', 'force_vehicle_id', 'label', 'force_label'];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['agency:id,short_name']);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Displayed label' => $record->displayed_label,
            'Agency' => $record->agency->short_name,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('agency')
                    ->content(fn (Vehicle $record): string => $record->agency->name)->hidden(fn (?Vehicle $record) => $record === null),
                Placeholder::make('original_vehicle_id')
                    ->content(fn (Vehicle $record): string => $record->vehicle_id)->hidden(fn (?Vehicle $record) => $record === null),
                Section::make()
                    ->schema([
                        TextInput::make('force_label')->label('Fleet label')->columnSpan(1)->hint('force_label')->helperText('Use to replace the vehicle number provided by the agency'),
                        TextInput::make('force_vehicle_id')->label('Custom identifier')->columnSpan(1)->hint('force_vehicle_id')->helperText('Use to replace an incorrect vehicle identifier provided by the agency (like a wrong VIN). Remember to change this field for every vehicle with a wrong vin!'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agency.short_name')
                    ->label('Agency')
                    ->sortable(),
                TagsColumn::make('tags.label')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('vehicle_type')
                    ->formatStateUsing(fn (VehicleType $state): string => $state->description)
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('displayed_label')
                    ->label('Label')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('ref')
                    ->sortable(),
                TextColumn::make('vinInformationOriginal.make')
                    ->label('Make')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('vinInformationOriginal.model')
                    ->label('Model')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y')
                    ->toggleable(),
            ])
            ->recordActions([
                EditAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->filters([
                Filter::make('onlyWithoutOperators')
                    ->query(fn (Builder $query): Builder => $query->withoutTypeOfTags(TagType::Operator))
                    ->toggle(),
                TernaryFilter::make('is_active'),
                SelectFilter::make('agency')->relationship('agency', 'short_name'),
                Filter::make('refStartsWith')->schema([
                    TextInput::make('refStartsWith'),
                ])->query(function (Builder $query, array $data): Builder {
                    if (! $data['refStartsWith']) {
                        return $query;
                    }

                    return $query->where('vehicle_id', 'LIKE', "{$data['refStartsWith']}%");
                }),
                Filter::make('forceLabelStartsWith')->schema([
                    TextInput::make('forceLabelStartsWith'),
                ])->query(function (Builder $query, array $data): Builder {
                    if (! $data['forceLabelStartsWith']) {
                        return $query;
                    }

                    return $query->where('force_label', 'LIKE', "{$data['forceLabelStartsWith']}%");
                }),
            ])
            ->toolbarActions([

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
                        Select::make('tagId')->options(Tag::orderBy('type')->pluck('label', 'id'))->label('Tag')->required(),
                    ])->icon('gmdi-label'),
            ])
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVehicles::route('/'),
            'edit' => EditVehicle::route('/{record}/edit'),
        ];
    }
}
