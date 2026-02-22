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

}
