<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'target_type' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
