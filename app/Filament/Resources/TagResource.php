<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers\AgenciesRelationManager;
use App\Filament\Resources\TagResource\RelationManagers\VehiclesRelationManager;
use App\Jobs\AddTagIconToMapbox;
use App\Models\Tag;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;

class TagResource extends Resource
{
    use Translatable;

    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'gmdi-label';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->columnSpan(['lg' => 2])->schema([
                    Card::make()->columns(3)->schema([
                        TextInput::make('label')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('short_label'),
                        TextInput::make('description')
                            ->columnSpan(3),
                    ]),
                    Section::make('Appearance')->schema([
                        TextInput::make('icon')->columnSpan(2),
                        ColorPicker::make('color')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                $set('dark_color', $state);
                            }),
                        ColorPicker::make('dark_color')->required(),
                        ColorPicker::make('text_color')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                $set('dark_text_color', $state);
                            }),
                        ColorPicker::make('dark_text_color'),
                        Toggle::make('show_on_map'),
                    ])->columns(2),
                ]),
                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Tag $record): string => $record->created_at->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Tag $record): string => $record->updated_at->diffForHumans()),

                            ])->hidden(fn (?Tag $record) => $record === null),
                    ])->columnSpan(['lg' => 1])
            ])->columns(3);
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('app.supported_languages'));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
