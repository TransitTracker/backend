<?php

namespace App\Filament\Resources;

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;
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

    protected static ?string $navigationIcon = 'gmdi-directions-bus';

    protected static ?string $recordTitleAttribute = 'vehicle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('agency')
                    ->content(fn (Vehicle $record): string => $record->agency->name)->hidden(fn (?Vehicle $record) => $record === null),
                Placeholder::make('original_ref')
                    ->content(fn (Vehicle $record): string => $record->vehicle)->hidden(fn (?Vehicle $record) => $record === null),
                Card::make()->columns(2)->schema([
                    TextInput::make('force_label')->label('Fleet label')->columnSpan(1)->hint('force_label')->helperText('Use to replace the vehicle number provided by the agency'),
                    TextInput::make('force_ref')->label('Custom identifier')->columnSpan(1)->hint('force_ref')->helperText('Use to replace an incorrect vehicle identifier provided by the agency (like a wrong VIN). Remember to change this field for every vehicle with a wrong vin!'),
                ]),
                /* Tabs::make('')->columnSpan(2)->tabs([
                    Tabs\Tab::make('Static data')->schema([
                        TextInput::make('vehicle')
                            ->required(),
                        Toggle::make('active')
                            ->required(),
                        BelongsToSelect::make('agency_id')->required()->relationship('agency', 'name'),
                        Select::make('icon')->options(['bus', 'tram', 'train'])->required(),
                    ]),
                    Tabs\Tab::make('Changing data')->schema([
                        TextInput::make('timestamp'),
                        TextInput::make('route')
                            ->required(),
                        TextInput::make('start'),
                        TextInput::make('gtfs_trip')->label('Trip (from feed)'),
                        TextInput::make('trip_id')->label('trip_id (relation)'),
                        TextInput::make('lat')->numeric(),
                        TextInput::make('lon')->numeric(),
                        TextInput::make('bearing')->numeric(),
                        TextInput::make('speed')->numeric(),
                        TextInput::make('stop_sequence')->numeric(),
                        TextInput::make('label'),
                        TextInput::make('plate'),
                        TextInput::make('odometer'),
                        Select::make('status')->options(VehicleStopStatus::asFlippedArray()),
                        Select::make('relationship')->options(ScheduleRelationship::asFlippedArray()),
                        Select::make('congestion')->options(CongestionLevel::asFlippedArray()),
                        Select::make('occupancy')->options(OccupancyStatus::asFlippedArray()),
                    ]),
                ]), */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agency.short_name')->label('Agency'),
                Tables\Columns\IconColumn::make('active')->boolean(),
                Tables\Columns\TextColumn::make('icon'),
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
