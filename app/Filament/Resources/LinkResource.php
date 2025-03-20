<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers\VehiclesRelationManager;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LinkResource extends Resource
{
    use Translatable;

    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'gmdi-link-tt';

    protected static ?string $recordTitleAttribute = 'internal_title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['internal_title', 'title'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->columnSpan(4)
                    ->inline(false),
                Forms\Components\TextInput::make('internal_title')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpan(3),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->columnSpan(3),
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->helperText(str('Available dynamic variable: `:id`, `:ref`, `:trip`')->inlineMarkdown()->toHtmlString())
                    ->columnSpanFull(),
                Forms\Components\Select::make('agencies')
                    ->multiple()
                    ->relationship('agencies', 'short_name')
                    ->label('Applies to new vehicles from agencies')
                    ->columnSpanFull(),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('internal_title'),
                Tables\Columns\TextColumn::make('link'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('agencies_count')->counts('agencies'),
                Tables\Columns\TextColumn::make('vehicles_count')->counts('vehicles'),
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
