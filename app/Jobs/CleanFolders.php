<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class CleanFolders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'default';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::delete([
            ...Storage::files('realtime'),
            ...Storage::allFiles('static'),
        ]);

        collect(Storage::directories('static'))->each(function ($directory) {
            Storage::deleteDirectory($directory);
        });

        $gitignore = "*\n.gitignore";

        Storage::put('realtime/.gitignore', $gitignore);
        Storage::put('static/.gitignore', $gitignore);
    }
}
