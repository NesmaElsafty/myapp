<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User permissions
            ['name' => 'user.create', 'display_name_en' => 'Create', 'display_name_ar' => 'إنشاء', 'group' => 'User'],
            ['name' => 'user.read', 'display_name_en' => 'Read', 'display_name_ar' => 'عرض', 'group' => 'User'],
            ['name' => 'user.update', 'display_name_en' => 'Update', 'display_name_ar' => 'تعديل', 'group' => 'User'],
            ['name' => 'user.delete', 'display_name_en' => 'Delete', 'display_name_ar' => 'حذف', 'group' => 'User'],
            ['name' => 'user.block', 'display_name_en' => 'Block', 'display_name_ar' => 'حظر', 'group' => 'User'],
            ['name' => 'user.unblock', 'display_name_en' => 'Unblock', 'display_name_ar' => 'فك الحظر', 'group' => 'User'],
            ['name' => 'user.export', 'display_name_en' => 'Export', 'display_name_ar' => 'تصدير', 'group' => 'User'],
            ['name' => 'user.blocklist', 'display_name_en' => 'Blocklist', 'display_name_ar' => 'قائمة الحظر', 'group' => 'User'],
            ['name' => 'user.toggleActive', 'display_name_en' => 'Toggle Active', 'display_name_ar' => 'تفعيل/تعطيل', 'group' => 'User'],
            
            // Role permissions
            ['name' => 'role.create', 'display_name_en' => 'Create', 'display_name_ar' => 'إنشاء', 'group' => 'Role'],
            ['name' => 'role.read', 'display_name_en' => 'Read', 'display_name_ar' => 'عرض', 'group' => 'Role'],
            ['name' => 'role.update', 'display_name_en' => 'Update', 'display_name_ar' => 'تعديل', 'group' => 'Role'],
            ['name' => 'role.delete', 'display_name_en' => 'Delete', 'display_name_ar' => 'حذف', 'group' => 'Role'],
            
            // Permission permissions
            ['name' => 'permission.read', 'display_name_en' => 'Read', 'display_name_ar' => 'عرض', 'group' => 'Permission'],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
