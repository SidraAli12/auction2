@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Your Auctions</h3>

        {{-- Only show "Create Auction" button if user is a Seller --}}
        @if(Auth::user()->role === 'seller')
            <a href="{{ route('auctions.create') }}" class="btn btn-primary btn-sm">+ Create Auction</a>
        @endif
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($auctions as $auction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $auction->product }}</td>
                    <td>{{ $auction->auction_start }}</td>
                    <td>{{ $auction->auction_end }}</td>

                    <td>
                        <span class="badge 
                            @if($auction->status == 'pending') bg-secondary
                            @elseif($auction->status == 'started') bg-info
                            @elseif($auction->status == 'sold') bg-success
                            @elseif($auction->status == 'expired') bg-danger
                            @endif">
                            {{ ucfirst($auction->status) }}
                        </span>
                    </td>

                    <td>
                        {{-- Seller Actions --}}
                        @if(Auth::user()->role === 'seller' && Auth::id() === $auction->user_id)
                            {{-- View Bids Button --}}
                            <a href="{{ route('auctions.bids', $auction->id) }}" class="btn btn-info btn-sm me-1">
                          View Bids
                              </a>


                            {{-- Edit/Delete --}}
                            <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this auction?')">Delete</button>
                            </form>
                        @endif

                        {{-- Buyer Action --}}
                        @if(Auth::user()->role === 'buyer' && Auth::id() !== $auction->user_id)
                            <a href="{{ route('bids.create', $auction->id) }}" 
                               class="btn btn-success btn-sm ms-1" 
                               style="font-weight: 500;">
                               Place Bid
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No auctions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection