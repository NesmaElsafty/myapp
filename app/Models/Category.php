<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];
    
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'types' => 'array',
        ];
    }

    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // get all category names
    public function getCategoryInputsNames(int $categoryId)
    {
        // i want to get all inputs name of all screens of the category and validation rules
        // i want to return an array of objects with name and validation rules
        return $this->screens()->with('inputs')->where('category_id', $categoryId)->get()->map(function ($screen) {
            return $screen->inputs->map(function ($input) {
                return [
                    'name' => $input->name,
                    'validation_rules' => $input->validation_rules,
                ];
            });
        })->toArray();
    }
}
