<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers\RegionsRelationManager;
use App\Models\Agency;
use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static ?string $navigationIcon = 'gmdi-other-houses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->columnSpan(['lg' => 2])->schema([
                    Card::make()->schema([
                        TextInput::make('name')
                            ->required()->columnSpan(2),
                        TextInput::make('slug')
                            ->required(),
                        TextInput::make('short_name')->required(),
                    ])->columns(2),
                    Section::make('Appearance')->schema([
                        ColorPicker::make('color')->required(),
                        ColorPicker::make('text_color')->required(),
                        TagsInput::make('cities')->required(),
                        Select::make('vehicles_type')->required()->options([
                            'bus' => 'Bus',
                            'train' => 'Train',
                            'tram' => 'Tram',
                        ])->label('Default vehicle type'),
                        KeyValue::make('license')->columnSpan(2),
                    ])->columns(2)->collapsed(),
                    Section::make('Static data')->schema([
                        TextInput::make('static_gtfs_url')->label('Static GTFS URL'),
                        Placeholder::make('static_etag')->label('Latest ETAG')->content(fn (Agency $record): string => $record->static_etag),
                    ])->collapsed(),
                    Section::make('Realtime data')->schema([

                        Select::make('realtime_type')->required()->options([
                            'gtfsrt' => 'GTFS-RT',
                            'gtfsrt-debug' => 'GTFS-RT Debug',
                            'nextbus-json' => 'NextBus JSON',
                        ]),
                        TextInput::make('realtime_url')->required()->columnSpan(2),
                        TextInput::make('cron_schedule')->columnSpan(3),
                    ])->collapsed()->columns(3),
                    // TODO: TextInput::make('realtime_options'),
                ]),
                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_active')
                                    ->required(),
                                Toggle::make('refresh_is_active')
                                    ->required(),
                            ]),
                        Card::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Agency $record): string => $record->created_at->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Agency $record): string => $record->updated_at->diffForHumans()),
                                Placeholder::make('timestamp')
                                    ->label('Lastest data from agency')
                                    ->content(fn (Agency $record): string => Carbon::createFromTimestamp($record->timestamp)->format('j M Y H:i')),

                            ])->hidden(fn (?Agency $record) => $record === null),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                BooleanColumn::make('is_active'),
                BooleanColumn::make('refresh_is_active'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RegionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
        ];
    }
}
