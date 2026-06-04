<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarriageResource\Pages;
use App\Models\Carriage;
use App\Models\CarriageType;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CarriageResource extends Resource
{
    protected static ?string $model = Carriage::class;

    protected static ?string $navigationIcon = 'gmdi-train-tt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agency.name'),
                TextColumn::make('carriage_id')
                    ->sortable(),
                TextColumn::make('label'),
                TextColumn::make('carriageType.make')
                    ->label('Make'),
                TextColumn::make('carriageType.model')
                    ->label('Model'),
                TextColumn::make('carriageType.carriage_category')
                    ->label('Category'),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                BulkAction::make('assignCarriageType')
                    ->form([
                        Select::make('carriageTypeId')
                            ->label('Carriage Type')
                            ->relationship(
                                name: 'carriageType',
                                titleAttribute: 'model',
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (CarriageType $record) => "{$record->make} {$record->model} [{$record->carriage_category->name}]"
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (array $data, Collection $records): void {
                        Carriage::whereKey($records->pluck('id'))
                            ->update([
                                'carriage_type_id' => $data['carriageTypeId'],
                            ]);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarriages::route('/'),
        ];
    }
}
