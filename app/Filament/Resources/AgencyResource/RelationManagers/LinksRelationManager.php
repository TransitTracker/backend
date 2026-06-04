<?php

namespace App\Filament\Resources\AgencyResource\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LinksRelationManager extends RelationManager
{
    protected static string $relationship = 'links';

    protected static ?string $recordTitleAttribute = 'internal_title';

    protected static ?string $label = 'Default links for new vehicles';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('internal_title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('internal_title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AssociateAction::make(),
            ])
            ->recordActions([
                DissociateAction::make(),
            ])
            ->toolbarActions([
                DissociateBulkAction::make(),
            ]);
    }
}
