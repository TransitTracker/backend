<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers\RegionsRelationManager;
use App\Models\Agency;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
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
                Tabs::make('General')->columnSpan(2)->tabs([
                    Tabs\Tab::make('General')->schema([
                        TextInput::make('name')
                            ->required()->columnSpan(2),
                        TextInput::make('slug')
                            ->required(),
                        TextInput::make('short_name')->required(),
                        Toggle::make('is_active')
                            ->required(),
                        Toggle::make('refresh_is_active')
                            ->required(),
                        TextInput::make('timestamp')
                            ->required()->numeric(),
                    ]),
                    Tabs\Tab::make('Data')->schema([
                        TextInput::make('static_gtfs_url'),
                        TextInput::make('realtime_url')->required(),
                        Select::make('realtime_type')->required()->options([
                            'gtfsrt' => 'GTFS-RT',
                            'nextbus-json' => 'NextBus JSON',
                        ]),
                        KeyValue::make('license'),
                        // TODO: TextInput::make('realtime_options'),
                        TextInput::make('cron_schedule'),
                    ]),
                    Tabs\Tab::make('Display')->schema([
                        TagsInput::make('cities')->required(),
                        Select::make('vehicles_type')->required()->options([
                            'bus' => 'Bus',
                            'train' => 'Train',
                            'tram' => 'Tram',
                        ]),
                        TextInput::make('color')
                            ->required()->type('color'),
                        TextInput::make('text_color')
                            ->required()->type('color'),
                    ]),
                ]),
            ]);
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
