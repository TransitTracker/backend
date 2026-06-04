<?php

namespace App\Filament\Resources;

use App\Enums\CarriageCategory;
use App\Filament\Resources\CarriageTypeResource\Pages;
use App\Models\Agency;
use App\Models\CarriageType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CarriageTypeResource extends Resource
{
    protected static ?string $model = CarriageType::class;

    protected static ?string $navigationIcon = 'gmdi-category-tt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ToggleButtons::make('carriage_category')
                    ->options(CarriageCategory::class)
                    ->columnSpanFull()
                    ->inline(),
                TextInput::make('make'),
                TextInput::make('model'),
                Repeater::make('automatic_mappings')
                    ->schema([
                        Select::make('agency_id')
                            ->label('Agency')
                            ->options(Agency::select('id', 'short_name')->get()->pluck('short_name', 'id'))
                            ->required(),
                        TextInput::make('min')
                            ->label('Minimum value')
                            ->integer()
                            ->required(),
                        TextInput::make('max')
                            ->label('Maximum value')
                            ->integer()
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->reorderable(false)
                    ->addActionAlignment(Alignment::Start)
                    ->cloneable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('carriage_category'),
                TextColumn::make('make'),
                TextColumn::make('model'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCarriageTypes::route('/'),
        ];
    }
}
