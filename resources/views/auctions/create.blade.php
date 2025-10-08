@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Create Auction</h3>

    <form action="{{ route('auctions.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Product</label>
            <input type="text" name="product" class="form-control" value="{{ old('product') }}">
            @error('product') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Auction Start</label>
            <input type="datetime-local" name="auction_start" class="form-control" value="{{ old('auction_start') }}">
            @error('auction_start') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Auction End</label>
            <input type="datetime-local" name="auction_end" class="form-control" value="{{ old('auction_end') }}">
            @error('auction_end') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button class="btn btn-success">Save Auction</button>
        <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
