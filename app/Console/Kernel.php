<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //$schedule->command('backup:run')->everyMinute();
        /* $schedule->command('backup:clean')->everyFiveMinutes();
        $schedule->command('backup:run')->everyFiveMinutes(); */
        $schedule->command('backup:clean')->daily()->at('00:00');
        $schedule->command('backup:run')->daily()->at('01:00');
        $schedule->command('email:send-birthday')->dailyAt('00:00');
        $schedule->command('email:send-finagrement')->dailyAt('08:00');
        $schedule->command('email:notify-end-agreements')->dailyAt('08:00');
        $schedule->command('email:send-training-reminders')->dailyAt('11:10');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
