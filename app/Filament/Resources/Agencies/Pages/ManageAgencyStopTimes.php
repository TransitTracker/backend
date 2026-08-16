<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\StopTime;
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

class ManageAgencyStopTimes extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'stopTimes';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-schedule-tt';

    protected static ?string $navigationLabel = 'Stop Times';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stop Time Details')
                    ->schema([
                        TextInput::make('gtfs_trip_id')->label('Trip ID')->disabled(),
                        TextInput::make('sequence')->label('Sequence')->disabled(),
                        TextInput::make('gtfs_stop_id')->label('Stop ID')->disabled(),
                        TextInput::make('departure')->label('Departure Time')->disabled(),
                    ])->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?StopTime $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?StopTime $record) => $record?->updated_at?->toDayDateTimeString()),
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
                TextColumn::make('sequence')
                    ->label('Seq')
                    ->sortable()
                    ->badge(),
                TextColumn::make('gtfs_stop_id')
                    ->label('Stop ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                TextColumn::make('stop.name')
                    ->label('Stop Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('departure')
                    ->label('Departure Time')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                Filter::make('trip_id')
                    ->schema([
                        TextInput::make('gtfs_trip_id')->label('Trip ID'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['gtfs_trip_id'] ?? null,
                        fn (Builder $query, $tripId) => $query->where('gtfs_trip_id', $tripId)
                    )),
                Filter::make('stop_id')
                    ->schema([
                        TextInput::make('gtfs_stop_id')->label('Stop ID'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['gtfs_stop_id'] ?? null,
                        fn (Builder $query, $stopId) => $query->where('gtfs_stop_id', $stopId)
                    )),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
