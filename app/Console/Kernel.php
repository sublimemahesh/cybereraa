<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('calculate:profit')->weekdays()->everyMinute()->withoutOverlapping();
        $schedule->command('calculate:profit')->weekdays()->dailyAt('00:01')->withoutOverlapping();
        // $schedule->command('calculate:commission')->weekdays()->dailyAt('00:01')->withoutOverlapping();

        // $schedule->command('calculate:staking-interest')->dailyAt('00:01')->withoutOverlapping();

        // $schedule->command('calculate:rank-benefit-earning')->weekdays()->dailyAt('00:01')->withoutOverlapping();

        // $schedule->command('calculate:rank-bonus')->monthly()->dailyAt('00:01')->withoutOverlapping();

        // $schedule->command('genealogy:assign')->everySixHours()->withoutOverlapping();

        // $schedule->command('remind:payment')->fridays()->at('01:00')->withoutOverlapping();

        $schedule->command('queue:work', ['--stop-when-empty'])->everyMinute()->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
