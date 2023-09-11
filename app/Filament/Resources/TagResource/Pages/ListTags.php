<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Enums\TagType;
use App\Filament\Resources\TagResource;
use App\Models\Tag;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

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
            BulkAction::make('generateSlug')
                ->action(function (Collection $records) {
                    $records->each(function (Tag $tag) {
                        $tag->slug = Str::slug($tag->short_label);
                        $tag->save();
                    });
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
