<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ExpireAuctionsCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ExpireAuctionsCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Auction start logic
        $schedule->command('auctions:start')->everyMinute();

        // Auction expiry logic
        $schedule->command('auctions:expire')->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
