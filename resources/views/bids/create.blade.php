@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Place a Bid on "{{ $auction->product }}"</h3>

    @if(session('error'))
        <div style="color:red;">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('bids.store', $auction->id) }}" method="POST">
        @csrf

        <div>
            <label>Bid Amount:</label>
            <input type="number" name="price" step="0.01" required>
            @error('price') <small style="color:red;">{{ $message }}</small> @enderror
        </div>

        <button type="submit">Place Bid</button>
    </form>
</div>
@endsection