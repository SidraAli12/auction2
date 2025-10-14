<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create($receiverId)
    {
        $receiver = User::findOrFail($receiverId);

        return view('messages.create', compact('receiver'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $req->receiver_id,
            'message' => $req->message,
        ]);

        return back()->with('success', 'Message sent!');
    }
}