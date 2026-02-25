<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemData extends Model
{
    protected $table = 'item_data';

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
