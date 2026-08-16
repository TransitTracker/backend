<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\Shape;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ManageAgencyShapes extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'shapes';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-timeline-tt';

    protected static ?string $navigationLabel = 'Shapes';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Shape Details')
                    ->schema([
                        TextInput::make('gtfs_shape_id')->label('Shape ID')->disabled(),
                        Placeholder::make('points_count')
                            ->label('Total Points')
                            ->content(fn (?Shape $record) => $record?->shape ? count($record->shape->getCoordinates()) : 0),
                        Placeholder::make('total_distance')
                            ->label('Total Distance')
                            ->content(fn (?Shape $record) => $record?->total_distance ? number_format($record->total_distance, 2).' km' : 'N/A'),
                    ])->columns(3),
                Section::make('GeoJSON')
                    ->schema([
                        Placeholder::make('geojson_preview')
                            ->label('Map Viewer')
                            ->content(function (?Shape $record): ?HtmlString {
                                if (! $record?->shape) {
                                    return null;
                                }
                                $json = json_encode($record->shape->toArray());
                                $url = 'https://geojson.io/#data=data:application/json,'.rawurlencode($json);

                                return new HtmlString(
                                    "<a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"text-primary-600 underline font-medium inline-flex items-center gap-1\">Open in geojson.io &nearr;</a>"
                                );
                            })
                            ->columnSpanFull(),
                        Textarea::make('geojson_value')
                            ->label('GeoJSON Value')
                            ->formatStateUsing(fn (?Shape $record) => $record?->shape ? json_encode($record->shape->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : null)
                            ->rows(8)
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?Shape $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?Shape $record) => $record?->updated_at?->toDayDateTimeString()),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gtfs_shape_id')
            ->columns([
                TextColumn::make('gtfs_shape_id')
                    ->label('Shape ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                TextColumn::make('points_count')
                    ->label('Points Count')
                    ->state(fn (Shape $record): int => $record->shape ? count($record->shape->getCoordinates()) : 0)
                    ->sortable(false),
                TextColumn::make('total_distance')
                    ->label('Total Distance')
                    ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2).' km' : '-')
                    ->sortable(),
                TextColumn::make('trips_count')
                    ->counts('trips')
                    ->label('Trips Count')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y H:i')
                    ->label('Last Updated')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                Action::make('geojson_io')
                    ->label('geojson.io')
                    ->icon('gmdi-open-in-new-tt')
                    ->color('gray')
                    ->url(fn (Shape $record): ?string => $record->shape ? 'https://geojson.io/#data=data:application/json,'.rawurlencode(json_encode($record->shape->toArray())) : null, shouldOpenInNewTab: true)
                    ->visible(fn (Shape $record): bool => filled($record->shape)),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
