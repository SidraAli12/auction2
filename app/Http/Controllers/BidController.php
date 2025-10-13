<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function create($auctionId)     // User jab kisi auction pe bid karne jata hai
    {
    $auction = Auction::findOrFail($auctionId);

    if (Auth::user()->role !== 'buyer') { //yaha buyer ky ilawa aur koi bhi bit nhi laga sakhtaa
        return redirect()->route('auctions.index')->with('error', 'Only buyers can place bids.');
    }

    if ($auction->user_id === Auth::id()) {
        return redirect()->route('auctions.index')->with('error', 'You cannot bid on your own auction.');
    }

    if ($auction->status !== 'started') { //expired aur sold pr bid nhinlaga sakhty 
        return redirect()->route('auctions.index')->with('error', 'This auction is not open for bidding.');
    }

    return view('bids.create', compact('auction'));
}
    public function store(Request $request, $auctionId)//gonna save our record 
    {
    $auction = Auction::findOrFail($auctionId);

    if (Auth::user()->role !== 'buyer') {
        return redirect()->route('auctions.index')->with('error', 'Only buyers can place bids.');
    }

    if ($auction->user_id === Auth::id()) {
        return redirect()->route('auctions.index')->with('error', 'You cannot bid on your own auction.');
    }

    if ($auction->status !== 'started') {
        return redirect()->route('auctions.index')->with('error', 'This auction is not open for bidding.');
    }

    $request->validate(['price' => 'required|numeric|min:1']);

    $userBidCount = Bid::where('auction_id', $auctionId)
        ->where('user_id', Auth::id())
        ->count();

    if ($userBidCount >= 3) {
        return redirect()->back()->with('error', 'You can only place 3 bids on the same auction.');
    }

    Bid::create([
        'auction_id' => $auctionId,
        'user_id' => Auth::id(),
        'price' => $request->price,
        'winner' => false,
    ]);

    return redirect()->route('auctions.index')->with('success', 'Bid placed successfully!');
}}