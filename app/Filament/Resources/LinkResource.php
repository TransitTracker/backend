<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages\CreateLink;
use App\Filament\Resources\LinkResource\Pages\EditLink;
use App\Filament\Resources\LinkResource\Pages\ListLinks;
use App\Filament\Resources\LinkResource\RelationManagers\VehiclesRelationManager;
use App\Models\Link;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class LinkResource extends Resource
{
    use Translatable;

    protected static ?string $model = Link::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-link-tt';

    protected static ?string $recordTitleAttribute = 'internal_title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['internal_title', 'title'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make()
                            ->columns(3)
                            ->schema([
                                TextInput::make('internal_title')
                                    ->required(),
                                TextInput::make('title')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('description')
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('link')
                                    ->required()
                                    ->helperText(str('Available dynamic variable: `:id`, `:ref`, `:trip`')->inlineMarkdown()->toHtmlString())
                                    ->columnSpanFull(),
                            ]),
                        Section::make('Default associations')
                            ->schema([
                                Select::make('agencies')
                                    ->multiple()
                                    ->relationship('agencies', 'short_name')
                                    ->label('Applies to new vehicles from agencies')
                                    ->columnSpanFull(),

                            ]),
                    ]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Toggle::make('is_active')
                                    ->default(true)
                                    ->columnSpan(4)
                                    ->inline(false),
                            ]),
                        Section::make()
                            ->schema([
                                Placeholder::make('id')
                                    ->label('ID')
                                    ->content(fn (Link $record): string => $record->id),
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Link $record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Link $record): ?string => $record->updated_at?->diffForHumans()),

                            ])->hidden(fn (?Link $record) => $record === null),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('internal_title'),
                TextColumn::make('link'),
                IconColumn::make('is_active')->boolean(),
                TextColumn::make('agencies_count')->counts('agencies'),
                TextColumn::make('vehicles_count')->counts('vehicles'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VehiclesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLinks::route('/'),
            'create' => CreateLink::route('/create'),
            'edit' => EditLink::route('/{record}/edit'),
        ];
    }
}
