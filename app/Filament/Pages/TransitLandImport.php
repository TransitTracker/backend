<?php

namespace App\Filament\Pages;

use App\Enums\VehicleType;
use App\Models\Agency;
use App\Models\TransitLandAgency;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TransitLandImport extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'gmdi-import-export';

    protected static ?string $navigationGroup = 'Tools';

    protected static ?string $title = 'Transit.land Import';

    protected static string $view = 'filament.pages.transit-land-import';

    public ?string $province = 'Québec';

    public bool $hideImported = true;

    public function mount(): void
    {
        $this->form->fill([
            'province' => 'Québec',
            'hideImported' => true,
        ]);

        $this->fetchData();
    }

    public function updatedProvince(): void
    {
        $this->fetchData();
        $this->resetTable();
    }

    public function updatedHideImported(): void
    {
        $this->resetTable();
    }

    protected function fetchData(): void
    {
        if (! $this->province) {
            return;
        }

        $fetchedAgencies = collect();
        $after = 0;
        $apiKey = config('transittracker.transitland_api_key');

        do {
            $response = Http::withHeaders([
                'apikey' => $apiKey,
            ])->get('https://transit.land/api/v2/rest/agencies', [
                'adm0_name' => 'Canada',
                'adm1_name' => $this->province,
                'limit' => 100,
                'after' => $after ?: null,
            ]);

            if (! $response->successful()) {
                Notification::make()
                    ->title('Error fetching from Transit.land')
                    ->body($response->body())
                    ->danger()
                    ->send();
                break;
            }

            $data = $response->json();
            $newAgencies = collect($data['agencies'] ?? []);

            $fetchedAgencies = $fetchedAgencies->merge($newAgencies);

            $after = $data['meta']['after'] ?? null;
        } while ($after);

        $existingTransitLandIds = Agency::whereNotNull('transitland_id')->pluck('transitland_id')->toArray();

        $processedAgencies = $fetchedAgencies->map(function ($agency) use ($existingTransitLandIds) {
            $onestopId = $agency['onestop_id'];
            $isImported = in_array($onestopId, $existingTransitLandIds);

            return [
                'id' => (string) $agency['id'],
                'onestop_id' => $onestopId,
                'agency_name' => $agency['agency_name'],
                'agency_id' => $agency['agency_id'],
                'operator_name' => $agency['operator']['name'] ?? null,
                'operator_short_name' => $agency['operator']['short_name'] ?? null,
                'operator_onestop_id' => $agency['operator']['onestop_id'] ?? null,
                'is_imported' => $isImported,
                'feed_onestop_id' => $agency['feed_version']['feed']['onestop_id'] ?? null,
                'province' => $this->province,
            ];
        })->toArray();

        // Cache this into Sushi model
        TransitLandAgency::sushiInsert($processedAgencies);
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('province')
                    ->options([
                        'Alberta' => 'Alberta',
                        'British Columbia' => 'British Columbia',
                        'Manitoba' => 'Manitoba',
                        'New Brunswick' => 'New Brunswick',
                        'Newfoundland and Labrador' => 'Newfoundland and Labrador',
                        'Nova Scotia' => 'Nova Scotia',
                        'Ontario' => 'Ontario',
                        'Prince Edward Island' => 'Prince Edward Island',
                        'Québec' => 'Québec',
                        'Saskatchewan' => 'Saskatchewan',
                        'Northwest Territories' => 'Northwest Territories',
                        'Nunavut' => 'Nunavut',
                        'Yukon' => 'Yukon',
                    ])
                    ->live()
                    ->required(),
                Toggle::make('hideImported')
                    ->label('Hide already imported')
                    ->live(),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = TransitLandAgency::query()->where('province', $this->province);

                if ($this->hideImported) {
                    $query->where('is_imported', false);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->getStateUsing(fn ($record) => $record->operator_name ?: $record->agency_name)
                    ->label('Agency Name'),
                TextColumn::make('short_name')
                    ->getStateUsing(fn ($record) => $record->operator_short_name ?: $record->agency_id)
                    ->label('Short Name'),
                TextColumn::make('onestop_id')
                    ->label('Onestop ID')
                    ->url(fn ($record) => 'https://www.transit.land/operators/'.($record->operator_onestop_id ?? $record->onestop_id))
                    ->openUrlInNewTab(),
                IconColumn::make('is_imported')
                    ->label('Imported')
                    ->boolean(),
            ])
            ->actions([
                Action::make('import')
                    ->label('Import')
                    ->button()
                    ->disabled(fn ($record) => $record->is_imported || ! $record->feed_onestop_id)
                    ->action(function ($record) {
                        $this->importAgency($record);
                    }),
            ])
            ->headerActions([])
            ->emptyStateHeading('No agencies found');
    }

    public function importAgency($record)
    {
        $apiKey = config('transittracker.transitland_api_key');

        $feedOnestopId = $record->feed_onestop_id;
        $onestopId = $record->onestop_id;

        if (! $feedOnestopId) {
            Notification::make()->title('Feed data not found')->danger()->send();

            return;
        }

        // Fetch feed details
        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->get("https://transit.land/api/v2/rest/feeds/{$feedOnestopId}");

        if (! $response->successful()) {
            Notification::make()
                ->title('Error fetching feed from Transit.land')
                ->body($response->body())
                ->danger()
                ->send();

            return;
        }

        $feedData = $response->json();

        if (! $feedData) {
            Notification::make()->title('Feed data not found')->danger()->send();

            return;
        }

        $shortName = $record->operator_short_name ?: ($record->agency_id ?: Str::slug($record->agency_name));
        $name = $record->operator_name ?: $record->agency_name;
        $slug = Str::slug($shortName);

        // Make sure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (Agency::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        Agency::create([
            'name' => $name,
            'short_name' => $shortName,
            'slug' => $slug,
            'transitland_id' => $onestopId,
            'color' => '#000000',
            'text_color' => '#FFFFFF',
            'default_vehicle_type' => VehicleType::Bus,
            'static_gtfs_url' => $feedData['urls']['static_current'] ?? null,
            'realtime_type' => 'gtfsrt',
            'realtime_url' => $feedData['urls']['realtime_vehicle_positions'] ?? null,
            'is_active' => false,
            'refresh_is_active' => false,
        ]);

        Notification::make()->title("Agency {$name} imported successfully")->success()->send();

        // Reload list
        $this->fetchData();
        $this->resetTable();
    }
}
