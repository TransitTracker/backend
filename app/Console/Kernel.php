<?php

namespace App\Console;

use App\Agency;
use App\Jobs\DispatchAgencies;
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
        $schedule->job(new DispatchAgencies(Agency::active()->get()), 'vehicles')->everyMinute();
        $schedule->command('download:clean')->dailyAt('3:55');
        $schedule->command('backup:clean')->dailyAt('01:00');
        $schedule->command('backup:run')->dailyAt('02:00');
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
