@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Bids for: {{ $auction->product }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bids->isEmpty())
        <p>No bids placed yet.</p>
    @else
        <table class="table table-bordered align-middle mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bidder</th>
                    <th>Amount</th>
                    <th>Placed At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bids as $bid)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bid->user->name }}</td>
                        <td>{{ $bid->amount }}</td>
                        <td>{{ $bid->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($bid->winner)
                                <span class="badge bg-success">Winner</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$bid->winner && $auction->status !== 'sold')
                                <form action="{{ route('auctions.acceptBid', [$auction->id, $bid->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" 
                                            onclick="return confirm('Accept this bid as winner?')">
                                        Accept
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('messages.create', $bid->user_id) }}" class="btn btn-sm btn-primary mt-1">
                                    Message
                                    </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('auctions.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
