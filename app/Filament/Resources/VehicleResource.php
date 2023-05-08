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

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'gmdi-directions-bus-tt';

    protected static ?string $recordTitleAttribute = 'vehicle_id';

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
                Tables\Columns\TextColumn::make('agency.short_name')->label('Agency'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('vehicle_type')->formatStateUsing(fn (VehicleType $state): string => $state->description),
                Tables\Columns\TextColumn::make('displayed_label')->label('Label'),
                Tables\Columns\TextColumn::make('ref'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('M d, Y'),
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
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
