<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Form input (field) belonging to a screen.
 *
 * Options JSON structure (one value per option, same for en/ar; labels per language):
 * - select/radio: { "choices": [ { "value": "male", "label_en": "Male", "label_ar": "ذكر" }, ... ] }
 * - checkbox: { "label_en": "I agree", "label_ar": "أوافق" }
 */
class Input extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'title_en',
        'title_ar',
        'placeholder_en',
        'placeholder_ar',
        'description_en',
        'description_ar',
        'type',
        'options',
        'is_required',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }
}
