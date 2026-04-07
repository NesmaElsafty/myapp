<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Item extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'payment_options' => 'array',
            'contact_type' => 'json',
            'visit_datetimes' => 'array',
            'published_at' => 'datetime',
            'promoted_until' => 'datetime',
            'is_active' => 'boolean',
            'is_appeared_in_item' => 'boolean',
            'need_licence' => 'boolean',
            'is_promoted' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(ItemInputValue::class);
    }

    public function inputValues(): HasMany
    {
        return $this->hasMany(ItemInputValue::class);
    }

    public function currentScreen(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'current_screen_id');
    }
}
