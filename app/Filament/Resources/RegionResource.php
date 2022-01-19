<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Filament\Resources\RegionResource\RelationManagers;
use App\Filament\Resources\RegionResource\RelationManagers\AgenciesRelationManager;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class RegionResource extends Resource
{
    use Translatable;

    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'gmdi-location-city';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('slug')->required(),
                TextInput::make('info_title')->required(),
                RichEditor::make('info_body')->required()->columnSpan('full'),
                KeyValue::make('map_center')->required(),
                RichEditor::make('credits')->required()->columnSpan('full'),
                TextInput::make('description')->required(),
                TextInput::make('meta_description')->required(),
                TextInput::make('image'),
            ]);
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('app.supported_languages'));
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
            // 'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
