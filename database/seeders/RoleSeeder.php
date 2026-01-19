<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin role
        $admin = Role::create([
            'name_en' => 'Admin',
            'name_ar' => 'مدير',
            'description_en' => 'Administrator with all permissions',
            'description_ar' => 'مدير بجميع الصلاحيات',
        ]);

        // Create Moderator role
        $moderator = Role::create([
            'name_en' => 'Moderator',
            'name_ar' => 'مشرف',
            'description_en' => 'Moderator with specific permissions controlled by admin',
            'description_ar' => 'مشرف بصلاحيات محددة يتحكم بها المدير',
        ]);

        // Assign all permissions to Admin
        $allPermissions = Permission::all();
        $admin->permissions()->attach($allPermissions->pluck('id'));

        // Moderator starts with no permissions (admin will assign specific ones)
        // You can add default permissions for moderator here if needed
        // For example, give moderator read permissions only:
        // $readPermissions = Permission::where('name', 'like', '%.read')->get();
        // $moderator->permissions()->attach($readPermissions->pluck('id'));
    }
}
