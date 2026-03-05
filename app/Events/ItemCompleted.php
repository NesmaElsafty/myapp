<?php

namespace App\Events;

use App\Models\Item;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemCompleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Item $item,
    ) {
    }
}

