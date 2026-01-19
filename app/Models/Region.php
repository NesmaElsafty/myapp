<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    protected $guarded = [];

    /**
     * Get the city that owns the region.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
