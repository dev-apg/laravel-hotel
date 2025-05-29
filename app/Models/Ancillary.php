<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ancillary extends Model
{
    protected $table = "ancillaries";

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Ancillary::class);
    }
}
