<?php

namespace App\Filament\Resources\LinkResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class VehiclesRelationManager extends RelationManager
{
    protected static string $relationship = 'vehicles';

    protected static ?string $recordTitleAttribute = 'displayed_label';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agency.short_name'),
                Tables\Columns\TextColumn::make('displayed_label'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
            ]);
    }    
}
