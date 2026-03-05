<?php

namespace App\Listeners;

use App\Events\ItemCompleted;

class HandleItemCompleted
{
    public function handle(ItemCompleted $event): void
    {
        // Side effects for completed items can be implemented here
    }
}

