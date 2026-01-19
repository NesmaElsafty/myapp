<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The roles that belong to the permission.
     */
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
