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

        if ($auction->user_id === Auth::id()) { //yaha check honga ky user apni he id sy tou bit nhi laga raha 

            return redirect()->route('auctions.index')->with('error', 'You cannot bid on your own auction.');// ager yes tou redirect karaye ga u cannot bit your own auction 
        }

        return view('bids.create', compact('auction'));
    }

    public function store(Request $request, $auctionId)//gonna save our record 
    {
        $auction = Auction::findOrFail($auctionId);

        if ($auction->user_id === Auth::id()) { //Again check karenga 
            return redirect()->route('auctions.index')->with('error', 'You cannot bid on your own auction.');
        }

        $request->validate([
            'price' => 'required|numeric|min:1', //Validation: price should be  required aur numeric honi chahiye
        ]);

        $userBidCount = Bid::where('auction_id', $auctionId)
            ->where('user_id', Auth::id())
            ->count();

        if ($userBidCount >= 3) { //if bids 3 sy ziyada hai tou erroe aaaye ga 
            return redirect()->back()->with('error', 'You can only place 3 bids on the same auction.');
        }

        Bid::create([ //create hojaye ga phr 
            'auction_id' => $auctionId,
            'user_id' => Auth::id(),
            'price' => $request->price,
        ]);

        return redirect()->route('auctions.index')->with('success', 'Bid placed successfully!');
    }
}
