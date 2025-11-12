<?php

namespace App\Filament\Resources\AlertResource\Pages;

use App\Filament\Resources\AlertResource;
use App\Models\Alert;
use App\Models\NotificationUser;
use App\Models\Region;
use App\Notifications\Push\NewAlert;
use Filament\Actions\Action;
use Filament\Actions\LocaleSwitcher;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use Notification;

class EditAlert extends EditRecord
{
    use Translatable;

    protected static string $resource = AlertResource::class;

    protected function getHeaderActions(): array
    {
        $activeUsersQuery = NotificationUser::query()
            ->where('is_active', true)
            ->where('subscribed_general_news', true);

        return [
            LocaleSwitcher::make(),
            Action::make('sendNotifications')
                ->fillForm(fn (Alert $record): array => [
                    'region' => $record->regions->count() === 1
                        ? $record->regions->first()?->id
                        : null,
                ])
                ->form([
                    Select::make('region')
                        ->options(Region::pluck('name', 'id'))
                        ->helperText('Optional. Force opening this alert in a specific region.'),
                ])
                ->requiresConfirmation()
                ->modalDescription("Are you sure you want to send a notification to {$activeUsersQuery->count()} users?")
                ->action(function (array $data, Alert $record) use ($activeUsersQuery) {
                    $users = $activeUsersQuery->get();
                    $region = isset($data['region']) ? Region::find($data['region']) : null;

                    Notification::send($users, new NewAlert($record, $region));
                })
                ->color('gray')
                ->icon('gmdi-notifications-active'),
        ];
    }
}
