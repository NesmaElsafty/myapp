<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'available_posts_limit' => 'integer',
        'plan_posts_limit' => 'integer',
        'golden_posts' => 'integer',
        'silver_posts' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    
    public function planDetail()
    {
        return $this->belongsTo(PlanDetails::class);
    }
}
