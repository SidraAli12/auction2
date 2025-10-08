@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Your Auctions</h3>
        <a href="{{ route('auctions.create') }}" class="btn btn-primary btn-sm">+ Create Auction</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Start</th>
                <th>End</th>
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
                        <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this auction?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No auctions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
