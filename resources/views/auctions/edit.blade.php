@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Auction</h3>

    <form action="{{ route('auctions.update', $auction->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Product</label>
            <input type="text" name="product" class="form-control" value="{{ old('product', $auction->product) }}">
        </div>
        <div class="mb-3">
            <label>Auction Start</label>
            <input type="datetime-local" name="auction_start" class="form-control" 
                   value="{{ old('auction_start', \Carbon\Carbon::parse($auction->auction_start)->format('Y-m-d\TH:i')) }}">
        </div>
        <div class="mb-3">
            <label>Auction End</label>
            <input type="datetime-local" name="auction_end" class="form-control" 
                   value="{{ old('auction_end', \Carbon\Carbon::parse($auction->auction_end)->format('Y-m-d\TH:i')) }}">
        </div>
        <button class="btn btn-primary">Update Auction</button>
        <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
