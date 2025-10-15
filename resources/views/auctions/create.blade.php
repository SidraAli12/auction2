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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('auctionForm');
    const alertBox = document.getElementById('alertBox');

    form.addEventListener('submit', async function(e) {
        e.preventDefault(); //this is going to skip the laoding 

        alertBox.className = '';
        alertBox.textContent = '';

        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('auctions.store') }}", { //it is  security token zaroori hota hai 
                                                                                 // POST requests me  warna 419 error aata hai.                                                              
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (response.ok) {
                alertBox.classList.add('alert', 'alert-success');
                alertBox.textContent = 'Auction created successfully! Redirecting...';
                setTimeout(() => window.location.href = "{{ route('auctions.index') }}", 500);
            } 
            else if (response.status === 422) {
                const data = await response.json();
                alertBox.classList.add('alert', 'alert-danger');
                alertBox.innerHTML = Object.values(data.errors).flat().join('<br>');
            } 
            else {
                alertBox.classList.add('alert', 'alert-danger');
                alertBox.textContent = ' Something went wrong.';
            }
        } catch (err) {
            alertBox.classList.add('alert', 'alert-danger');
            alertBox.textContent = 'Server error: ' + err.message;
        }
    });
});
</script>
@endsection
