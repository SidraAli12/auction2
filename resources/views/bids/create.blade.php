@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Place a Bid on "{{ $auction->product }}"</h3>

    <div id="alertBox"></div> {{-- yahan message show hoga --}}

    <form id="bidForm" method="POST">
        @csrf
        <input type="hidden" name="auction_id" value="{{ $auction->id }}">

        <div class="mb-3">
            <label>Bid Amount:</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
            @error('price') <small style="color:red;">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Place Bid</button>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#bidForm').submit(function(e){
    e.preventDefault(); // form reload hone se rokta hai

    let formData = $(this).serialize(); // form data collect kar liya

    $.ajax({
        url: "{{ route('bids.store', $auction->id) }}", // Laravel route
        type: "POST",
        data: formData,
        success: function(res){
            $('#alertBox').html('<div class="alert alert-success">Bid placed successfully!</div>');
            $('#bidForm')[0].reset(); // form clear kar diya
        },
        error: function(xhr){
            $('#alertBox').html('<div class="alert alert-danger">Failed to place bid!</div>');
        }
    });
});
</script>
@endsection

