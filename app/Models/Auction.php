<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product',
        'auction_start',
        'auction_end',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

