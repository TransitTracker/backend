<?php

namespace App\Filament\Resources;

use App\Enums\AlertCategory;
use App\Enums\AlertStatus;
use App\Filament\Resources\AlertResource\Pages\CreateAlert;
use App\Filament\Resources\AlertResource\Pages\EditAlert;
use App\Filament\Resources\AlertResource\Pages\ListAlerts;
use App\Filament\Resources\AlertResource\Widgets\AlertStatusOverview;
use App\Models\Alert;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class AlertResource extends Resource
{
    use Translatable;

    protected static ?string $model = Alert::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-warning-tt';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'subtitle'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make()->schema([
                            TextInput::make('title')->required()->columnSpan(2),
                            Select::make('category')
                                ->options(AlertCategory::class),
                            TextInput::make('subtitle')->required()->columnSpanFull(),
                            RichEditor::make('body')->required()->columnSpanFull(),
                            Toggle::make('is_regional')
                                ->live()
                                ->afterStateUpdated(fn (Set $set, bool $state) => ! $state && $set('regions', [])),
                            Select::make('regions')
                                ->columnSpan(2)
                                ->multiple()
                                ->relationship('regions', 'name')
                                ->preload()
                                ->visible(fn (Get $get): bool => $get('is_regional')),
                        ])->columns(['lg' => 3]),
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
                        Section::make()
                            ->schema([
                                ToggleButtons::make('status')
                                    ->required()
                                    ->default(AlertStatus::Draft)
                                    ->options(AlertStatus::class),
                                DatePicker::make('new_status_date')
                                    ->label('Program new status')
                                    ->requiredWith('new_status'),
                                Select::make('new_status')
                                    ->hiddenLabel()
                                    ->options(AlertStatus::class)
                                    ->requiredWith('new_status_date'),
                            ]),
                        Section::make()
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
                TextColumn::make('status')->badge(),
                TextColumn::make('title')
                    ->description(fn (Alert $record): string => $record->subtitle),
                TextColumn::make('category')->badge(),
                TextColumn::make('regions_count')->counts('regions'),
                TextColumn::make('created_at')->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(AlertStatus::class),
                SelectFilter::make('category')
                    ->options(AlertCategory::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => ListAlerts::route('/'),
            'create' => CreateAlert::route('/create'),
            'edit' => EditAlert::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AlertStatusOverview::class,
        ];
    }
}
