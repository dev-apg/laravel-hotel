<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{

    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_id',
        'user_id',
        'from',
        'to',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function extras(): BelongsToMany
    {
        return $this->belongsToMany(Extra::class);
    }
}
