<?php

namespace App\Filament\Resources;

use App\Enums\RegionImageStatus;
use App\Filament\Resources\RegionImageResource\Pages;
use App\Models\RegionImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegionImageResource extends Resource
{
    protected static ?string $model = RegionImage::class;

    protected static ?string $navigationIcon = 'gmdi-image-o';

    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('region_id')
                    ->relationship('region', 'name')
                    ->required(),
                TextInput::make('author_name')
                    ->required(),
                TextInput::make('author_email')
                    ->email()
                    ->required(),
                TextInput::make('author_link')
                    ->url(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('content/regions')
                    ->columnSpanFull()
                    ->required(),
                Select::make('status')
                    ->options(RegionImageStatus::asSelectArray())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->disk('public'),
                TextColumn::make('region.name')
                    ->sortable(),
                TextColumn::make('author_name')
                    ->searchable(),
                TextColumn::make('author_email')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (RegionImageStatus $state): string => match ($state->value) {
                        RegionImageStatus::Pending => 'warning',
                        RegionImageStatus::Accepted => 'success',
                        RegionImageStatus::Rejected => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(RegionImageStatus::asSelectArray()),
                SelectFilter::make('region_id')
                    ->relationship('region', 'name'),
            ])
            ->actions([
                Action::make('accept')
                    ->icon('gmdi-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (RegionImage $record): bool => $record->status->value !== RegionImageStatus::Accepted)
                    ->action(function (RegionImage $record) {
                        $record->update(['status' => RegionImageStatus::Accepted]);
                        $record->region->update(['active_image_id' => $record->id]);
                    }),
                Action::make('reject')
                    ->icon('gmdi-close')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (RegionImage $record): bool => $record->status->value === RegionImageStatus::Pending)
                    ->action(fn (RegionImage $record) => $record->update(['status' => RegionImageStatus::Rejected])),
                EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListRegionImages::route('/'),
            'create' => Pages\CreateRegionImage::route('/create'),
            'edit' => Pages\EditRegionImage::route('/{record}/edit'),
        ];
    }
}
