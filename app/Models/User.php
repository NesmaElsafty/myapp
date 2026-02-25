<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'specialty_areas' => 'array',
        ];
    }

    /**
     * Get the origin user (only for individuals with origin_id set)
     */
    public function origin()
    {
        return $this->belongsTo(User::class, 'origin_id');
    }

    /**
     * Get the individuals belonging to this origin (when type is origin)
     */
    public function individuals()
    {
        return $this->hasMany(User::class, 'origin_id')->where('type', 'individual');
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the alerts that belongs to the user.
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
