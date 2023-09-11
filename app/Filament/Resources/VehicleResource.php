<?php

namespace App\Filament\Resources;

use App\Enums\TagType;
use App\Enums\VehicleType;
use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers\TagsRelationManager;
use App\Models\Link;
use App\Models\Tag;
use App\Models\Vehicle;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'gmdi-directions-bus-tt';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('agency')
                    ->content(fn (Vehicle $record): string => $record->agency->name)->hidden(fn (?Vehicle $record) => $record === null),
                Placeholder::make('original_vehicle_id')
                    ->content(fn (Vehicle $record): string => $record->vehicle_id)->hidden(fn (?Vehicle $record) => $record === null),
                Card::make()->columns(2)->schema([
                    TextInput::make('force_label')->label('Fleet label')->columnSpan(1)->hint('force_label')->helperText('Use to replace the vehicle number provided by the agency'),
                    TextInput::make('force_vehicle_id')->label('Custom identifier')->columnSpan(1)->hint('force_vehicle_id')->helperText('Use to replace an incorrect vehicle identifier provided by the agency (like a wrong VIN). Remember to change this field for every vehicle with a wrong vin!'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agency.short_name')
                    ->label('Agency')
                    ->sortable(),
                Tables\Columns\TagsColumn::make('tags.label')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->formatStateUsing(fn (VehicleType $state): string => $state->description)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('displayed_label')
                    ->label('Label')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ref')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vinInformationOriginal.make')
                    ->label('Make')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vinInformationOriginal.model')
                    ->label('Model')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d, Y')
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ], position: Tables\Enums\ActionsPosition::BeforeColumns)
            ->filters([
                Filter::make('onlyWithoutOperators')
                    ->query(fn (Builder $query): Builder => $query->withoutTypeOfTags(TagType::Operator))
                    ->toggle(),
                Tables\Filters\TernaryFilter::make('is_active'),
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
            ])
            ->bulkActions([

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
            ])
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
