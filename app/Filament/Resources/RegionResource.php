<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Filament\Resources\RegionResource\RelationManagers\AgenciesRelationManager;
use App\Models\Region;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegionResource extends Resource
{
    use Translatable;

    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'gmdi-location-city-tt';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    private static function convertStringToBbox(string $bbox): array
    {
        $coordinates = explode(',', $bbox);

        $array = [];
        for ($i = 0; $i < count($coordinates); $i += 2) {
            $array[] = [$coordinates[$i], $coordinates[$i + 1]];
        }

        return $array;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        TextInput::make('name')->columnSpan(4)
                            ->required(),
                        TextInput::make('slug')
                            ->required()
                            ->columnSpan(2)
                            ->disabledOn('edit'),
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('content/regions')
                            ->image()
                            ->columnSpanFull(),
                        RichEditor::make('credits')
                            ->columnSpanFull(),
                        //  TODO: Fix credits
                        //                        RichEditor::make('credits_fr')
                        //                            ->hint('Français')
                        //                            ->afterStateHydrated(fn (Set $set, string $operation, Region $record) => $operation === 'edit' && $set('credits_en', $record->getTranslation('credits', 'fr')))
                        //                            ->dehydrateStateUsing(fn (?string $state, Region $record) => filled($state) && $record->setTranslation('credits', 'fr', $state))
                        //                            ->columnSpanFull()
                        //                            ->disableToolbarButtons(['attachFiles']),
                        TextInput::make('map_box')
                            ->columnSpan(2)
                            ->required()
                            ->hint('Caution: no validation.')
                            ->hintColor('danger')
                            ->helperText(view('filament/fields-helper/bbox'))
                            ->afterStateHydrated(fn (TextInput $component, ?array $state) => filled($state) && $component->state(implode(',', array_merge(...$state))))
                            ->dehydrateStateUsing(fn (string $state): array => self::convertStringToBbox($state)),
                        KeyValue::make('map_center')
                            ->columnSpan(2)
                            ->required()
                            ->helperText('Needs: lat and lon'),
                        TextInput::make('map_zoom')
                            ->columnSpan(2)
                            ->required()
                            ->integer(),
                        Textarea::make('description')
                            ->columnSpan(3)
                            ->autosize()
                            ->required(),
                        Textarea::make('meta_description')
                            ->columnSpan(3)
                            ->autosize()
                            ->required(),
                        Section::make('Deprecated field')
                            ->collapsed()
                            ->schema([
                                TextInput::make('info_title')
                                    ->hint('Deprecated')
                                    ->hintColor('warning'),
                                RichEditor::make('info_body')
                                    ->hint('Deprecated')
                                    ->hintColor('warning'),
                            ]),
                    ])->columns(6),
                    Section::make([
                        Placeholder::make('id')
                            ->content(fn (Region $record): string => $record->id),
                        Placeholder::make('updated_at')
                            ->content(fn (Region $record): ?string => $record->updated_at?->toDayDateTimeString()),
                        Placeholder::make('created_at')
                            ->content(fn (Region $record): ?string => $record->created_at?->toDayDateTimeString()),
                    ])
                        ->grow(false)
                        ->visibleOn('edit'),
                ])->columnSpanFull()->from('md'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AgenciesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
