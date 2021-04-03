<?php

namespace App\Console;

use App\Jobs\DispatchAgencies;
use App\Models\Agency;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command('download:clean')->dailyAt('03:55');
        $schedule->command('backup:clean')->dailyAt('02:00');
        $schedule->command('backup:run')->dailyAt('02:15');
        $schedule->command('backup:monitor')->dailyAt('02:30');
        $schedule->command('agency:update-actives')->dailyAt('03:00');
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
