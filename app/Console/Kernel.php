<?php

namespace App\Console;

use App\Jobs\CleanFolders;
use App\Jobs\RealtimeData\CheckTimestamps;
use App\Jobs\RealtimeData\DispatchAgencies;
use App\Models\Agency;
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
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new DispatchAgencies(Agency::active()->get()), 'vehicles')->everyMinute()->unlessBetween('03:54', '03:56');
        $schedule->job(new CheckTimestamps(), 'default')->everyThreeMinutes();
        $schedule->command('backup:clean')->dailyAt('02:00');
        $schedule->command('backup:run')->dailyAt('02:15');
        $schedule->command('backup:monitor')->dailyAt('02:30');
        $schedule->command('schedule-monitor:sync')->dailyAt('02:45');
        $schedule->command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->dailyAt('02:50');
        $schedule->command('static:update')->dailyAt('03:00');
        $schedule->command('download:clean')->dailyAt('03:55');
        $schedule->job(new CleanFolders(), 'gtfs')->dailyAt('03:55');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
