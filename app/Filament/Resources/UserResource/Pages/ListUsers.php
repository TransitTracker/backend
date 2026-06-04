<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->model(User::class)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->required()
                        ->email(),
                    TextInput::make('password')
                        ->required()
                        ->suffixAction(
                            Action::make('generatePassword')
                                ->icon('gmdi-refresh')
                                ->action(function (Set $set) {
                                    $set('password', Str::password(12));
                                })
                        ),
                ])
                ->mutateDataUsing(function (array $data): array {
                    $data['password'] = Hash::make($data['password']);

                    return $data;
                })
                ->createAnother(false),
        ];
    }
}
