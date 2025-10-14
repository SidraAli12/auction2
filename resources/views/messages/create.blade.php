@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Message to {{ $receiver->name }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

        <textarea name="message" class="form-control mb-3" rows="4"  required></textarea>

        <button class="btn btn-primary">Send</button>
    </form>
</div>

@endsection
