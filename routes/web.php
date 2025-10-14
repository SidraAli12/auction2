<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\MessageController;




Route::get('/', fn() => redirect()->route('login.form'));

// Register
Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Login
Route::get('login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->resource('auctions', AuctionController::class);

Route::middleware('auth')->group(function () {
    Route::get('/bids/{auction}/create', [BidController::class, 'create'])->name('bids.create');
    Route::post('/bids/{auction}', [BidController::class, 'store'])->name('bids.store');
});
Route::get('/auctions/{auction}/bids', [AuctionController::class, 'bids'])
    ->name('auctions.bids');

Route::post('/auctions/{auction}/bids/{bid}/accept', [AuctionController::class, 'acceptBid'])
    ->name('auctions.acceptBid');

    Route::get('/message/create/{receiver}', [MessageController::class, 'create'])->name('messages.create');
Route::post('/message/store', [MessageController::class, 'store'])->name('messages.store');
