<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\Trip;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageAgencyTrips extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'trips';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-directions-transit-filled-tt';

    protected static ?string $navigationLabel = 'Trips';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Trip Details')
                    ->schema([
                        TextInput::make('gtfs_trip_id')->label('GTFS Trip ID')->disabled(),
                        TextInput::make('gtfs_route_id')->label('GTFS Route ID')->disabled(),
                        TextInput::make('headsign')->label('Headsign')->disabled(),
                        TextInput::make('short_name')->label('Short Name')->disabled(),
                    ])->columns(2),
                Section::make('Associations')
                    ->schema([
                        TextInput::make('gtfs_service_id')->label('Service ID')->disabled(),
                        TextInput::make('gtfs_shape_id')->label('Shape ID')->disabled(),
                        TextInput::make('gtfs_block_id')->label('Block ID')->disabled(),
                        TextInput::make('expiration')->label('Expiration')->disabled(),
                    ])->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?Trip $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?Trip $record) => $record?->updated_at?->toDayDateTimeString()),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gtfs_trip_id')
            ->columns([
                TextColumn::make('gtfs_trip_id')
                    ->label('Trip ID')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('gtfs_route_id')
                    ->label('Route ID')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('headsign')
                    ->label('Headsign')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('short_name')
                    ->label('Trip Short Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('gtfs_service_id')
                    ->label('Service ID')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('gtfs_shape_id')
                    ->label('Shape ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('gtfs_block_id')
                    ->label('Block ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('stop_times_count')
                    ->counts('stopTimes')
                    ->label('Stops Count')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('route_id')
                    ->schema([
                        TextInput::make('gtfs_route_id')->label('Route ID'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['gtfs_route_id'] ?? null,
                        fn (Builder $query, $routeId) => $query->where('gtfs_route_id', 'like', "{$routeId}%")
                    )),
                Filter::make('service_id')
                    ->schema([
                        TextInput::make('gtfs_service_id')->label('Service ID'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['gtfs_service_id'] ?? null,
                        fn (Builder $query, $serviceId) => $query->where('gtfs_service_id', $serviceId)
                    )),
                Filter::make('block_id')
                    ->schema([
                        TextInput::make('gtfs_block_id')->label('Block ID'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['gtfs_block_id'] ?? null,
                        fn (Builder $query, $blockId) => $query->where('gtfs_block_id', $blockId)
                    )),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
