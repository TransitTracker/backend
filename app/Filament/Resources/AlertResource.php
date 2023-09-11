<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlertResource\Pages;
use App\Models\Alert;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AlertResource extends Resource
{
    use Translatable;

    protected static ?string $model = Alert::class;

    protected static ?string $navigationIcon = 'gmdi-warning-tt';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'subtitle'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Card::make()->schema([
                            TextInput::make('title')->required(),
                            TextInput::make('subtitle')->required(),
                            RichEditor::make('body')->required(),
                            Select::make('regions')
                                ->multiple()
                                ->relationship('regions', 'name')
                                ->preload(),
                        ]),
                        Section::make('Appearance')->schema([
                            Select::make('color')
                                ->options([
                                    'default' => 'Default',
                                    'error' => 'Error',
                                    'error-container' => 'Error container',
                                ])
                                ->default('default')
                                ->required(),
                            Textarea::make('icon')->required(),
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('content/alerts')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1920')
                                ->imageResizeTargetHeight('1080'),
                        ])->collapsible(),
                        Section::make('Action')->schema([
                            TextInput::make('action')
                                ->label('Type'),
                            KeyValue::make('action_parameters')
                                ->label('Parameters'),
                        ])->collapsed(),
                    ]),
                Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_active'),
                                Toggle::make('can_be_closed'),
                                DateTimePicker::make('expiration'),
                            ]),
                        Card::make()
                            ->schema([
                                Placeholder::make('id')
                                    ->label('ID')
                                    ->content(fn (Alert $record): string => $record->id),
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn (Alert $record): ?string => $record?->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified')
                                    ->content(fn (Alert $record): ?string => $record?->updated_at?->diffForHumans()),
                            ])
                            ->hiddenOn('create'),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('regions_count')->counts('regions'),
                Tables\Columns\TextColumn::make('expiration')->since(),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->filters([
                Filter::make('is_active')->query(fn (Builder $query): Builder => $query->active())->default(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
}
