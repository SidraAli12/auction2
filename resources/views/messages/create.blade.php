@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Message to {{ $receiver->name }}</h4>

    <div id="alertBox"></div>

    <form id="messageForm" action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

        <textarea name="message" class="form-control mb-3" rows="4" required></textarea>

        <button class="btn btn-primary">Send</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#messageForm').submit(function(e){
    e.preventDefault(); //laod ko roky ga 
    let form = $(this);
    $('#alertBox').html('<div class="alert alert-info">Sending...</div>');

    $.post("{{ route('messages.store') }}", form.serialize(), function(res){
        if (res.success) {
            $('#alertBox').html('<div class="alert alert-success">' + res.message + '</div>');
            form[0].reset();
        }
    }).fail(function(){
        $('#alertBox').html('<div class="alert alert-danger">Failed to send!</div>');
    });
});
</script>
@endsection
