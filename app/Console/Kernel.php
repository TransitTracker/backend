<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Rinvex\Statistics\Jobs\CleanStatisticsRequests;
use Rinvex\Statistics\Jobs\CrunchStatistics;

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
        $schedule->command('agency:refresh-actives')->everyMinute()->unlessBetween('1:00', '4:00');
        $schedule->command('agency:clean-all')->weeklyOn(1, '1:15');
        $schedule->command('agency:update-actives')->weeklyOn(2, '1:15');
        $schedule->job(new CrunchStatistics(), 'stats')->everyFiveMinutes();
        $schedule->job(new CleanStatisticsRequests(), 'stats')->dailyAt('2:00');

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
