<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    
    public function showForm()  //This method simply shows the registration page.
    //ye func bladeform register ka show kry ge 
    {
        return view('auth.register');
    }

    
    public function register(Request $request) //ye method jub call honga jub reg form submit honga post ky through
                                                
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6', //Hash::make(), meaning it’s securely encrypted.
        ]);

        $user = User::create([
            'name' => $request->name,  //yaha hum jo reg karty hue fields dengy aur user create karengy 
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registration successful!');
    } // redirect kara denga after reg to deshaboard
}
