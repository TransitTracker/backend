<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\Stop;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ManageAgencyStops extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'stops';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-place-tt';

    protected static ?string $navigationLabel = 'Stops';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stop Details')
                    ->schema([
                        TextInput::make('gtfs_stop_id')->label('GTFS Stop ID')->disabled(),
                        TextInput::make('code')->label('Stop Code')->disabled(),
                        TextInput::make('name')->label('Stop Name')->columnSpanFull()->disabled(),
                    ])->columns(2),
                Section::make('Coordinates & Location')
                    ->schema([
                        Placeholder::make('latitude')
                            ->label('Latitude')
                            ->content(fn (?Stop $record) => $record?->position?->latitude),
                        Placeholder::make('longitude')
                            ->label('Longitude')
                            ->content(fn (?Stop $record) => $record?->position?->longitude),
                        Placeholder::make('map_link')
                            ->label('Map View')
                            ->content(function (?Stop $record): ?HtmlString {
                                if (! $record?->position) {
                                    return null;
                                }
                                $lat = $record->position->latitude;
                                $lon = $record->position->longitude;

                                return new HtmlString(
                                    "<a href=\"https://www.google.com/maps/search/?api=1&query={$lat},{$lon}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"text-primary-600 underline font-medium inline-flex items-center gap-1\">View on Google Maps &nearr;</a>"
                                );
                            })
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?Stop $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?Stop $record) => $record?->updated_at?->toDayDateTimeString()),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('gtfs_stop_id')
                    ->label('Stop ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('position')
                    ->label('Coordinates')
                    ->state(fn (Stop $record): ?string => $record->position ? "{$record->position->latitude}, {$record->position->longitude}" : null)
                    ->url(fn (Stop $record): ?string => $record->position ? "https://www.google.com/maps/search/?api=1&query={$record->position->latitude},{$record->position->longitude}" : null, shouldOpenInNewTab: true)
                    ->icon('gmdi-open-in-new-tt')
                    ->iconPosition('after')
                    ->toggleable(),
                TextColumn::make('stop_times_count')
                    ->counts('stopTimes')
                    ->label('Stop Times Count')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
