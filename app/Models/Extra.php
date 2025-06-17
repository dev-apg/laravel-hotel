<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Extra extends Model
{
    protected $table = "extras";

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Extra::class);
    }
}
