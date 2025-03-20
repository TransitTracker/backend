<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Enums\VehicleType;
use App\Filament\Resources\AgencyResource;
use App\Jobs\SyncIconToMapbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EditAgency extends EditRecord
{
    protected static string $resource = AgencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('staticUpdate')
                    ->form([
                        Toggle::make('forceRefresh'),
                        CheckboxList::make('files')->options([
                            'calendar.txt' => 'calendar.txt',
                            'routes.txt' => 'routes.txt',
                            'stops.txt' => 'stops.txt',
                            'trips.txt' => 'trips.txt',
                            'stop_times.txt' => 'stop_times.txt',
                            'shapes.txt' => 'shapes.txt',
                        ])->bulkToggleable()->helperText('You must select at least one file.'),
                    ])
                    ->action(function (array $data) {
                        $countFiles = count($data['files']);

                        if (! $countFiles) {
                            return Notification::make()
                                ->title('You must choose at least one file to update.')
                                ->danger()
                                ->send();
                        }

                        Artisan::call('static:update', ['agency' => $this->record->slug, '--force' => $data['forceRefresh'], '--file' => $data['files']]);

                        return Notification::make()
                            ->title('Static data refresh launched!')
                            ->body("The server will update {$countFiles} files for {$this->record->short_name}.")
                            ->success()
                            ->send();
                    }),
                Action::make('realtimeUpdate')
                    ->action(function () {
                        Artisan::call('realtime:update', ['agency' => $this->record->slug]);

                        return Notification::make()
                            ->title('Realtime refresh launched!')
                            ->success()
                            ->send();
                    }),
                Action::make('forceRealtimeUpdate')
                    ->action(function () {
                        Artisan::call('realtime:update', ['agency' => $this->record->slug, '--force' => true]);

                        return Notification::make()
                            ->title('Realtime refresh launched!')
                            ->body('With force option activated.')
                            ->success()
                            ->send();
                    }),
                Action::make('downloadBusIcon')->action('downloadBus')->color('gray'),
                Action::make('syncBusIconToMapbox')
                    ->action(function () {
                        SyncIconToMapbox::dispatch($this->record, VehicleType::Bus())->onQueue('default');

                        return Notification::make()
                            ->title('Syncinc bus icon to Mapbox!')
                            ->success()
                            ->send();
                    }),
            ]),
        ];
    }

    public function downloadBus(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='35' height='35' viewBox='0 0 9.2604162 9.2604169' id='svg6019'>
                <metadata id='metadata6016' />
                <g id='layer1' transform='translate(0,-287.73957)'>
                    <path
                        style='fill:{$this->record->color};fill-opacity:1;stroke:{$this->record->text_color};stroke-width:0.09146457;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:normal;'
                        d='m 4.6302083,287.7853 c -1.76984,0 -3.20126,1.43142 -3.20126,3.20126 0,2.40095 3.20126,5.9452 3.20126,5.9452 0,0 3.20126,-3.54425 3.20126,-5.9452 0,-1.76984 -1.43142,-3.20126 -3.20126,-3.20126 z'
                        id='path7283' />
                    <path style='fill:{$this->record->text_color};fill-opacity:1;stroke:none;stroke-width:0.17149599' id='path959'
                        d='m 3.2582413,291.95151 c 0,0.15092 0.06688,0.2864 0.171496,0.38072 v 0.30527 c 0,0.0943 0.07717,0.17149 0.171495,0.17149 h 0.171497 c 0.09432,0 0.171495,-0.0772 0.171495,-0.17149 v -0.1715 h 1.371969 v 0.1715 c 0,0.0943 0.07717,0.17149 0.171495,0.17149 h 0.171496 c 0.09432,0 0.171497,-0.0772 0.171497,-0.17149 v -0.30527 c 0.104612,-0.0943 0.171496,-0.2298 0.171496,-0.38072 v -1.71496 c 0,-0.60023 -0.613956,-0.68598 -1.371969,-0.68598 -0.758012,0 -1.371967,0.0858 -1.371967,0.68598 z m 0.600235,0.1715 c -0.142341,0 -0.257244,-0.1149 -0.257244,-0.25725 0,-0.14234 0.114903,-0.25724 0.257244,-0.25724 0.142342,0 0.257244,0.1149 0.257244,0.25724 0,0.14235 -0.114902,0.25725 -0.257244,0.25725 z m 1.543464,0 c -0.142341,0 -0.257244,-0.1149 -0.257244,-0.25725 0,-0.14234 0.114903,-0.25724 0.257244,-0.25724 0.142342,0 0.257244,0.1149 0.257244,0.25724 0,0.14235 -0.114902,0.25725 -0.257244,0.25725 z m 0.257244,-1.02898 h -2.057952 v -0.85748 h 2.057952 z' />
                </g>
            </svg>";
        }, "tt-{$this->record->slug}-bus.svg"
        );
    }
}
