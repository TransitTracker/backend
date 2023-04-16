<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\StopTime;
use App\Models\Trip;
use Bus;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use ZipArchive;

class ExtractAndDispatchStaticGtfs implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?ZipArchive $zip = null;

    private ?string $directory = null;

    public function __construct(private Agency $agency, private string $zipFile, private array $files = [
        'calendar.txt',
        'routes.txt',
        'stops.txt',
        'trips.txt',
        'stop_times.txt',
        'shapes.txt',
    ])
    {
    }

    public function handle(): void
    {
        // Open (will only unzip needed files)
        $this->zip = new ZipArchive();
        $file = $this->zip->open($this->zipFile);

        if (! $file) {
            return;
        }

        // Set and create extract folder
        $time = now()->getTimestamp();
        $this->directory = "static/{$this->agency->slug}-{$time}";
        Storage::makeDirectory($this->directory);

        $jobsChains = [];

        foreach ($this->files as $file) {
            $job = match ($file) {
                'calendar.txt' => ProcessGtfsServices::class,
                'routes.txt' => ProcessGtfsRoutes::class,
                'stops.txt' => ProcessGtfsStops::class,
                'trips.txt' => ProcessGtfsTrips::class,
                'stop_times.txt' => ProcessGtfsStopTimes::class,
                'shapes.txt' => ProcessGtfsShapes::class,
            };

            [$chunkSize, $model] = match ($file) {
                'stop_times.txt' => [200_000, StopTime::class],
                'trips.txt' => [50_000, Trip::class],
                default => [0, null],
            };

            $jobsChains[] = $this->extractFile($file, $job, $chunkSize, $model);
        }

        Bus::batch($jobsChains)->dispatch();

        $this->zip->close();

        $this->zip = null;

        return;
    }

    private function extractFile(string $file, string $job, int $chunkSize, string $model = null): array
    {
        $filePath = "{$this->directory}/{$file}";

        $content = $this->zip->getFromName($file);

        // If there is no calendar file, continue without it
        if (! $content && $file === 'calendar.txt') {
            return;
        }

        Storage::put($filePath, $content);

        if ($chunkSize) {
            // Remove old records
            $model::where('agency_id', $this->agency->id)->delete();

            $reader = Reader::createFromPath(Storage::path($filePath))->setHeaderOffset(0);
            $size = ceil(count($reader) / $chunkSize);

            $jobs = [];
            for ($i = 0; $i <= $size - 1; $i++) {
                $jobs[] = new $job($this->agency, Storage::path($filePath), $i * $chunkSize);
            }

            return $jobs;
        }

        return [new $job($this->agency, Storage::path($filePath))];
    }
}
