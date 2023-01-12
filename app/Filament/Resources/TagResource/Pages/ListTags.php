<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Enums\TagType;
use App\Filament\Resources\TagResource;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ListTags extends ListRecords
{
    use Translatable;

    protected static string $resource = TagResource::class;

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('changeType')
                ->action(function (Collection $records, array $data): void {
                    foreach ($records as $record) {
                        $record->type = $data['type'];
                        $record->save();
                    }
                })
                ->form([
                    Select::make('type')->options(TagType::asFlippedArray()),
                ])->icon('gmdi-category'),
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
