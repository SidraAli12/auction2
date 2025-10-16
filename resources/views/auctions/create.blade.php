@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Create Auction</h3>

    <form action="{{ route('auctions.store') }}" method="POST" class="mt-3" id="auctionForm">
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
        <button type="submit" class="btn btn-success">Save Auction</button>
        <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Back</a>
        <div id="alertBox" class="mt-3"></div>
    </form>
</div>
@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $("#auctionForm").on("submit", function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('auctions.store') }}",//Request jati hai AuctionController@store() par
            type: "POST",
            data: $(this).serialize(),//then data serialize honga means server ko
            success: function(res){
                $("#successMessage").html(
                    '<div class="alert alert-success">Auction created successfully!</div>'
                );
                setTimeout(() => window.location.href = "{{ route('auctions.index') }}", 800);
            },
            error: function(){
                $("#successMessage").html(
                    '<div class="alert alert-danger">Error while creating auction!</div>'
                );
            }
        });
    });
});
</script>
@endsection
