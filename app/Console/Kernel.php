<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
         'App\Console\Commands\CheckUnpaidOrders',
         'App\Console\Commands\UpdateDeliveryStatus'

    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('orders:check-unpaid')->dailyAt('00:01');
        $schedule->command('delivery:update-status')->dailyAt('00:01');
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
