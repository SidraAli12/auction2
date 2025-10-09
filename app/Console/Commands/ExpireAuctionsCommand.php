<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class ExpireAuctionsCommand extends Command
{
    
    
    protected $signature = 'auctions:expire';

    
    protected $description = 'Mark auctions as expired when their end time has passed';

    
    public function handle()
    {
        $now = Carbon::now();

       
        $expired = Auction::where('auction_end', '<', $now)
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);

        $this->info(" {$expired} auctions marked as expired.");
    }
}
