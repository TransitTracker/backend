<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Enums\VehicleType;
use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\Route;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ManageAgencyRoutes extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'routes';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-alt-route-tt';

    protected static ?string $navigationLabel = 'Routes';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Route Details')
                    ->schema([
                        TextInput::make('gtfs_route_id')->label('GTFS Route ID')->disabled(),
                        TextInput::make('short_name')->label('Short Name')->disabled(),
                        TextInput::make('long_name')->label('Long Name')->columnSpanFull()->disabled(),
                        TextInput::make('type')
                            ->label('Type')
                            ->formatStateUsing(fn ($state) => VehicleType::hasValue((int) $state) ? VehicleType::fromValue((int) $state)->description : $state)
                            ->disabled(),
                    ])->columns(2),
                Section::make('Appearance')
                    ->schema([
                        TextInput::make('color')->label('Route Color')->disabled(),
                        TextInput::make('text_color')->label('Text Color')->disabled(),
                    ])->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?Route $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?Route $record) => $record?->updated_at?->toDayDateTimeString()),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('short_name')
            ->columns([
                TextColumn::make('gtfs_route_id')
                    ->label('Route ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                TextColumn::make('short_name')
                    ->label('Short Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('long_name')
                    ->label('Long Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => VehicleType::hasValue((int) $state) ? VehicleType::fromValue((int) $state)->description : $state)
                    ->badge()
                    ->sortable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->state(fn (Route $record): ?string => $record->color ? (str_starts_with($record->color, '#') ? $record->color : "#{$record->color}") : null)
                    ->copyable(),
                ColorColumn::make('text_color')
                    ->label('Text Color')
                    ->state(fn (Route $record): ?string => $record->text_color ? (str_starts_with($record->text_color, '#') ? $record->text_color : "#{$record->text_color}") : null)
                    ->copyable(),
                TextColumn::make('trips_count')
                    ->counts('trips')
                    ->label('Trips')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Route Type')
                    ->options(VehicleType::asSelectArray()),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
