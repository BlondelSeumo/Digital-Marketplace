<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (licenseType(2) && @settings('premium')->status) {
            $schedule->command('app:subscription-expired-notify')->everyMinute();
            $schedule->command('app:subscription-about-to-expire-notify')->everyMinute();
            $schedule->command('app:subscription-rest-total-downloads')->daily();
        }

        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

        $schedule->command('app:reset-item-monthly-views')->monthlyOn(1, '00:00');

        $schedule->command('app:refresh-trending-items')->daily();
        $schedule->command('app:refresh-best-selling-items')->daily();

        $schedule->command('app:delete-unpaid-transactions')->hourly();

        $schedule->command('app:discounts-start')->everyMinute();
        $schedule->command('app:discounts-end')->everyMinute();

        $schedule->command('app:delete-chunks')->hourly();
        $schedule->command('app:delete-expired-uploaded-files')->hourly();

        $schedule->command('app:sitemap-generate')->daily();

        $schedule->command('disposable:update')->weekly();
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