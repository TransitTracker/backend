<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlertResource\Pages;
use App\Models\Alert;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class AlertResource extends Resource
{
    use Translatable;

    protected static ?string $model = Alert::class;

    protected static ?string $navigationIcon = 'gmdi-warning';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->columnSpan(2),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('can_be_closed')
                    ->required(),
                Forms\Components\Textarea::make('icon'),
                Forms\Components\TextInput::make('color')
                    ->required(),
                Forms\Components\RichEditor::make('body')->columnSpan(2),
                Forms\Components\BelongsToManyMultiSelect::make('regions')->relationship('regions', 'name')->columnSpan(2),
                Forms\Components\DateTimePicker::make('expiration'),
                Forms\Components\TextInput::make('image'),
                Forms\Components\TextInput::make('action'),
                Forms\Components\KeyValue::make('action_parameters'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('regions_count')->counts('regions'),
                Tables\Columns\BooleanColumn::make('is_active'),
                Tables\Columns\TextColumn::make('expiration')->dateTime('M d, Y H:i'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y'),
            ])
            ->filters([
                Filter::make('is_active')->query(fn (Builder $query): Builder => $query->active()),
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
            'index' => Pages\ListAlerts::route('/'),
            'create' => Pages\CreateAlert::route('/create'),
            'edit' => Pages\EditAlert::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('app.supported_languages'));
    }
}
