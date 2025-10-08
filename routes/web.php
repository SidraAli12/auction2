<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn() => redirect()->route('login.form'));

// Register
Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Login
Route::get('login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (protected)
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Auctions CRUD (next step)
Route::middleware('auth')->resource('auctions', AuctionController::class);
