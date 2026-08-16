<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Gtfs\Service;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageAgencyServices extends ManageRelatedRecords
{
    protected static string $resource = AgencyResource::class;

    protected static string $relationship = 'services';

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-calendar-month-tt';

    protected static ?string $navigationLabel = 'Services (Calendar)';

    protected static string|\UnitEnum|null $navigationGroup = 'Static GTFS';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Calendar')
                    ->schema([
                        TextInput::make('gtfs_service_id')->label('Service ID')->disabled()->columnSpanFull(),
                        TextInput::make('start_date')->label('Start Date')->disabled(),
                        TextInput::make('end_date')->label('End Date')->disabled(),
                    ])->columns(2),
                Section::make('Active Days of Week')
                    ->schema([
                        Checkbox::make('monday')->label('Monday')->disabled(),
                        Checkbox::make('tuesday')->label('Tuesday')->disabled(),
                        Checkbox::make('wednesday')->label('Wednesday')->disabled(),
                        Checkbox::make('thursday')->label('Thursday')->disabled(),
                        Checkbox::make('friday')->label('Friday')->disabled(),
                        Checkbox::make('saturday')->label('Saturday')->disabled(),
                        Checkbox::make('sunday')->label('Sunday')->disabled(),
                    ])->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        Placeholder::make('created_at')->content(fn (?Service $record) => $record?->created_at?->toDayDateTimeString()),
                        Placeholder::make('updated_at')->content(fn (?Service $record) => $record?->updated_at?->toDayDateTimeString()),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gtfs_service_id')
            ->columns([
                TextColumn::make('gtfs_service_id')
                    ->label('Service ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                TextColumn::make('active_days')
                    ->label('Active Days')
                    ->state(function (Service $record): array {
                        $days = [];
                        if ($record->monday) {
                            $days[] = 'Mon';
                        }
                        if ($record->tuesday) {
                            $days[] = 'Tue';
                        }
                        if ($record->wednesday) {
                            $days[] = 'Wed';
                        }
                        if ($record->thursday) {
                            $days[] = 'Thu';
                        }
                        if ($record->friday) {
                            $days[] = 'Fri';
                        }
                        if ($record->saturday) {
                            $days[] = 'Sat';
                        }
                        if ($record->sunday) {
                            $days[] = 'Sun';
                        }

                        return $days;
                    })
                    ->badge()
                    ->color('success'),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->sortable(),
                TextColumn::make('trips_count')
                    ->counts('trips')
                    ->label('Trips Count')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('weekdays')
                    ->label('Active on Weekdays (Mon-Fri)')
                    ->query(fn (Builder $query): Builder => $query->where('monday', 1)->where('friday', 1)),
                Filter::make('weekends')
                    ->label('Active on Weekends (Sat/Sun)')
                    ->query(fn (Builder $query): Builder => $query->where('saturday', 1)->orWhere('sunday', 1)),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
