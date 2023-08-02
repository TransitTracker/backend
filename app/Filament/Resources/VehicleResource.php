<?php

namespace App\Filament\Resources;

use App\Enums\VehicleType;
use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers\TagsRelationManager;
use App\Models\Vehicle;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
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

    protected static function getGlobalSearchEloquentQuery(): Builder
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
            ->filters([
                //
            ]);
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
