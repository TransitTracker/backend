<?php

namespace App\Console;

use App\Jobs\CleanFolders;
use App\Jobs\RealtimeData\CheckTimestamps;
use App\Jobs\Tags\SyncTagsWithFleetStats;
use App\Models\FailedJob;
use App\Models\Gtfs\Shape;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('realtime:update')->everyMinute()->unlessBetween('03:34', '03:56');
        $schedule->job(new CheckTimestamps(), 'default')->everyThreeMinutes();
        $schedule->job(new SyncTagsWithFleetStats(), 'default')->everyTwoHours();
        $schedule->command('schedule-monitor:sync')->dailyAt('02:45');
        $schedule->command('model:prune', ['--model' => [Shape::class, FailedJob::class, MonitoredScheduledTaskLogItem::class]])->dailyAt('02:50');
        $schedule->command('static:update')->dailyAt('03:00');
        $schedule->job(new CleanFolders(), 'static')->dailyAt('03:55');
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('cache:prune-stale-tags')->hourly();
        $schedule->command('queue:prune-batches')->daily();
        $schedule->command('queue:prune-failed')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
