<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The permissions that belong to the role.
     */

    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * Get the users that belong to the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
