<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'country'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
