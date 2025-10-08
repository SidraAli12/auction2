<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('user_id', Auth::id())->latest()->get(); // wohi auctions fetch hongy jo logged in hai 

        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('auctions.create'); //auction data ky saath return honga view
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255', //form mrin fields dengy
            'auction_start' => 'required|date',
            'auction_end' => 'required|date|after:auction_start',
        ]);

        Auction::create([ //create hojaye ga 
            'user_id' => Auth::id(),
            'product' => $request->product,
            'auction_start' => $request->auction_start,
            'auction_end' => $request->auction_end,
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully.');
    }

    public function edit(Auction $auction) // Only the owner of the auction can access this page

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
}
