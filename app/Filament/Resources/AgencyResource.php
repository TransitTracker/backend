<?php

namespace App\Filament\Resources;

use App\Enums\AgencyFeature;
use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers\LinksRelationManager;
use App\Filament\Resources\AgencyResource\RelationManagers\RegionsRelationManager;
use App\Models\Agency;
use Carbon\Carbon;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static ?string $navigationIcon = 'gmdi-other-houses-tt';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'short_name', 'slug'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->columnSpan(['lg' => 2])->schema([
                    Section::make()->schema([
                        TextInput::make('name')
                            ->required()->columnSpan(2),
                        TextInput::make('slug')
                            ->required(),
                        TextInput::make('short_name')->required(),
                        TagsInput::make('features')
                            ->columnSpanFull()
                            ->suggestions(AgencyFeature::getValues())
                            ->hint('Flags for custom features'),
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
                        Placeholder::make('latest_etag')
                            ->label('Latest ETAG')
                            ->content(fn (Agency $record): string => $record->static_etag)
                            ->visibleOn('edit'),
                    ])->collapsed(),
                    Section::make('Realtime data')->schema([
                        Select::make('realtime_type')->required()->options([
                            'gtfsrt' => 'GTFS-RT',
                            'gtfsrt-debug' => 'GTFS-RT Debug',
                            'javascript-gtfsrt' => 'Javascript GTFS-RT',
                            'nextbus-json' => 'NextBus JSON',
                        ]),
                        TextInput::make('realtime_url')->required()->columnSpan(2),
                        TextInput::make('cron_schedule')->columnSpan(3),
                        KeyValue::make('headers')->columnSpan(3),
                    ])->collapsed()->columns(3),
                    Section::make('exo Vin settings')
                        ->schema([
                            Toggle::make('is_exo_sector')->helperText('Enabling this feature allows an agency to be visible in the VIN directory, receive suggestions, and generate vehicle information from the VIN.')->columnSpan(3),
                            TextInput::make('name_slug')->columnSpan(2),
                            TextInput::make('exo_order_id')->numeric(),
                            Textarea::make('area_path')->columnSpan(3),
                        ])
                        ->description('This section is intended for the bus sectors of exo, an agency in Montreal.')
                        ->collapsed()
                        ->columns(3),
                ]),
                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_active')
                                    ->required(),
                                Toggle::make('is_archived')
                                    ->required(),
                                Toggle::make('refresh_is_active')
                                    ->required(),
                            ]),
                        Section::make()
                            ->schema([
                                Placeholder::make('id')
                                    ->label('ID')
                                    ->content(fn (Agency $record): ?string => $record->id),
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Agency $record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Agency $record): ?string => $record->updated_at?->diffForHumans()),
                                Placeholder::make('timestamp')
                                    ->label('Lastest data from agency')
                                    ->content(fn (Agency $record): ?string => Carbon::createFromTimestamp($record->timestamp ?? null)->format('j M Y H:i')),

                            ])->visibleOn('edit'),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                IconColumn::make('is_active')->boolean(),
                IconColumn::make('refresh_is_active')->boolean(),
                TextColumn::make('cron_schedule')->toggleable(),
                TextColumn::make('features')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('regions.name'),
            ])
            ->actions([
                ReplicateAction::make()
                    ->excludeAttributes(['slug', 'is_active', 'refresh_is_active'])
                    ->form([
                        TextInput::make('slug')->required(),
                        Toggle::make('is_active')->default(false),
                        Toggle::make('refresh_is_active')->default(false),
                    ])
                    ->beforeReplicaSaved(function (Agency $replica, array $data): void {
                        $replica->fill($data);
                    }),
            ])
            ->filters([
                SelectFilter::make('regions')->relationship('regions', 'name'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LinksRelationManager::class,
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
