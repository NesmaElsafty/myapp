<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemInputValue extends Model
{
    protected $table = 'item_input_values';

    protected $guarded = [];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class);
    }
}

