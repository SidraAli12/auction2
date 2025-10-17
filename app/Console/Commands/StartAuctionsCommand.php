<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class StartAuctionsCommand extends Command
{
    protected $signature = 'auctions:start';

    protected $description = 'Mark auctions as started when their start time has arrived';

    public function handle()
    {
        $now = Carbon::now();

        // Find all auctions whose start time has arrived and are still pending
        $started = Auction::where('auction_start', '<=', $now)
            ->where('status', 'pending')
            ->update(['status' => 'started']);

        $this->info("{$started} auctions marked as started.");
    }
}
