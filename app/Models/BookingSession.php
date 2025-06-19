<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSession extends Model
{
    protected $fillable = [
        'session_token',
        'details',
        'expires_at'
    ];

    protected $casts = [
        'booking_data' => 'array',
        'expires_at' => 'datetime'
    ];
}
