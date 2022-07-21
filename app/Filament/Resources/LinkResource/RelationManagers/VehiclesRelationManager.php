<?php

namespace App\Filament\Resources\LinkResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class VehiclesRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'vehicles';

    protected static ?string $recordTitleAttribute = 'vehicle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agency.short_name'),
                Tables\Columns\TextColumn::make('displayed_label'),
            ])
            ->filters([
                //
            ]);
    }
}
