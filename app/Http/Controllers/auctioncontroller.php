<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please login first.'); //ager user login nhi hai tou ridirect login page 
    }

    if ($user->role === 'seller') {
    $auctions = Auction::where('user_id', $user->id)->latest()->get();//if he is seller tou apny auction dekh sakhta hain
} elseif ($user->role === 'buyer') {
    $auctions = Auction::whereHas('user', function ($query) { //aur ager buyer hai tou tou sub sellers ky auction dekhy ga 
        $query->where('role', 'seller');
    })
    ->latest()
    ->get();
} else {
    $auctions = collect();
}


    return view('auctions.index', compact('auctions'));
}
    public function create()
    {
        if (Auth::user()->role !== 'seller') { //only seller can create auctions kyun buyer tou nhi kary ga na 
            return redirect()->route('auctions.index')->with('error', 'Only sellers can create auctions.');
        }

        return view('auctions.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'seller') {
            return redirect()->route('auctions.index')->with('error', 'Only sellers can create auctions.');
        }

        $request->validate([
            'product' => 'required|string|max:255',
            'auction_start' => 'required|date',
            'auction_end' => 'required|date|after:auction_start',
        ]);

        Auction::create([
            'user_id' => Auth::id(),
            'product' => $request->product,
            'auction_start' => $request->auction_start,
            'auction_end' => $request->auction_end,
            'status' => 'pending',
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully.');
    }

    public function edit(Auction $auction)
    {
        $this->authorizeOwner($auction);
        return view('auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction)
    {
        $this->authorizeOwner($auction); 

        $request->validate([
            'product' => 'required|string|max:255',
            'auction_start' => 'required|date',
            'auction_end' => 'required|date|after:auction_start',
        ]);

        $auction->update($request->only('product', 'auction_start', 'auction_end'));

        return redirect()->route('auctions.index')->with('success', 'Auction updated successfully.');
    }

    public function destroy(Auction $auction)
    {
        $this->authorizeOwner($auction);
        $auction->delete();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted.');
    }

    private function authorizeOwner(Auction $auction)
    {
        if ($auction->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function bids(Auction $auction)  //yaha hum sary bids ko seller ky auction pr show karengy 
    {
        $this->authorizeOwner($auction);

        $bids = $auction->bids()->with('user')->orderByDesc('created_at')->get();

        return view('auctions.bids', compact('auction', 'bids'));
    }

    public function acceptBid(Auction $auction, Bid $bid)
    {
        $this->authorizeOwner($auction); //ownership check karebngy 

        if ($bid->auction_id !== $auction->id) { //check karengy ky ye bit isi auction ke hai
            abort(404);
        }

        DB::transaction(function () use ($auction, $bid) {
            $auction->update(['status' => 'sold']);

            Bid::where('auction_id', $auction->id)->update(['winner' => false]);// Jis bid ko seller ne accept kiya uska "winner" true kar do


            $bid->update(['winner' => true]);
        });

        return redirect()->route('auctions.bids', $auction->id)
            ->with('success', 'Bid accepted and auction marked as sold.');
    }
}