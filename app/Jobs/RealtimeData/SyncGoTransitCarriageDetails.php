<?php

namespace App\Jobs\RealtimeData;

use App\Models\Agency;
use App\Models\Carriage;
use App\Models\CarriageType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SyncGoTransitCarriageDetails implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch types once at the start of the job and cache them in memory
        $carriageTypes = CarriageType::whereNotNull('automatic_mappings')->get();

        $go = Agency::firstWhere('slug', 'go');
        $key = $go->headers['key'] ?? '';
        $response = Http::get("https://api.openmetrolinx.com/OpenDataAPI/api/V1/Fleet/Consist/All?key={$key}");
        $response->throw();

        $carriages = $response->collect('AllConsists.Consists')
            ->flatMap(function (array $consist) use ($go, $carriageTypes) {
                return collect($consist['Lineup'] ?? [])->map(function (array $carriage) use ($consist, $go, $carriageTypes) {
                    $carriageNumber = (int) $carriage['Number'];

                    return [
                        'agency_id' => $go->id,
                        'carriage_id' => $carriage['Number'],
                        'vehicle_id' => $consist['EngineNumber'],
                        'sequence' => $carriage['Order'],
                        'carriage_type_id' => $this->resolveCarriageType($carriageTypes, $carriageNumber, $go->id),
                    ];
                });
            });

        // Skip the database query if the API returned an empty dataset
        if ($carriages->isEmpty()) {
            return;
        }

        // Chunk the upsert to prevent database query parameter limits
        $carriages->chunk(500)->each(function ($chunk) {
            Carriage::upsert(
                $chunk->toArray(),
                uniqueBy: ['agency_id', 'carriage_id'],
                update: ['sequence', 'vehicle_id', 'carriage_type_id'],
            );
        });
    }

    /**
     * Match the carriage number to its correct type ID based on automatic mappings.
     */
    private function resolveCarriageType(Collection $types, int $carriageNumber, int $agencyId): ?int
    {
        foreach ($types as $type) {
            $mappings = $type->automatic_mappings;

            if (empty($mappings)) {
                continue;
            }

            foreach ($mappings as $mapping) {
                if ((int) ($mapping['agency_id'] ?? 0) !== $agencyId) {
                    continue;
                }

                $min = (int) ($mapping['min'] ?? 0);
                $max = (int) ($mapping['max'] ?? 0);

                if ($carriageNumber >= $min && $carriageNumber <= $max) {
                    return $type->id;
                }
            }
        }

        return null;
    }
}
