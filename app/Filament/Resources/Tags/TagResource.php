<?php

namespace App\Filament\Resources\Tags;

use App\Enums\TagType;
use App\Filament\Resources\Tags\Pages\CreateTag;
use App\Filament\Resources\Tags\Pages\EditTag;
use App\Filament\Resources\Tags\Pages\ListTags;
use App\Filament\Resources\Tags\RelationManagers\AgenciesRelationManager;
use App\Filament\Resources\Tags\RelationManagers\VehiclesRelationManager;
use App\Models\Tag;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class TagResource extends Resource
{
    use Translatable;

    protected static ?string $model = Tag::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-label-tt';

    public static function getGloballySearchableAttributes(): array
    {
        return ['label', 'short_label', 'slug'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->columnSpan(['lg' => 2])->schema([
                    Section::make()->columns(3)->schema([
                        TextInput::make('label')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('short_label')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('description')
                            ->columnSpan(2),
                        TextInput::make('slug'),
                    ]),
                    Section::make('Appearance')->schema([
                        TextInput::make('icon')->columnSpan(2),
                        ColorPicker::make('color')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('dark_color', $state);
                            }),
                        ColorPicker::make('dark_color')->required(),
                        ColorPicker::make('text_color')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('dark_text_color', $state);
                            }),
                        ColorPicker::make('dark_text_color'),
                        Toggle::make('show_on_map'),
                    ])->columns(2),
                ]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('type')->options(TagType::asFlippedArray()),
                            ]),
                        Section::make()
                            ->schema([
                                Placeholder::make('id')
                                    ->label('ID')
                                    ->content(fn (Tag $record): string => $record->id),
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Tag $record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Tag $record): ?string => $record->updated_at?->diffForHumans()),

                            ])->hidden(fn (?Tag $record) => $record === null),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('label')->view('tables.columns.tag-preview'),
                TextColumn::make('type')->formatStateUsing(fn (TagType $state): string => $state->description),
                TextColumn::make('slug')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(TagType::asFlippedArray()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AgenciesRelationManager::class,
            VehiclesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
