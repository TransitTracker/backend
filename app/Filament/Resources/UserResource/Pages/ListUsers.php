<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(User::class)
                ->form([
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
                ->mutateFormDataUsing(function (array $data): array {
                    $data['password'] = Hash::make($data['password']);

                    return $data;
                })
                ->createAnother(false),
        ];
    }
}
