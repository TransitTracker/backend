<?php

namespace App\Filament\Resources\AgencyResource\RelationManagers;

use App\Filament\Resources\RegionResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class RegionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'regions';

    protected static ?string $recordTitleAttribute = 'name';

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
}
