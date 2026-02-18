<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * جلب جميع الأدوار مع الصلاحيات
     */
    public function getAllRoles(int $perPage = 10)
    {
        return Role::with('permissions')->paginate($perPage);
    }

    /**
     * جلب الدور مع الصلاحيات حسب المعرف
     */
    public function getRoleById(int $id): ?Role
    {
        return Role::with('permissions')->find($id);
    }

    /**
     * جلب جميع الصلاحيات
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    /**
     * إنشاء دور جديد مع الصلاحيات
     */
    public function createRole(array $data)
    {
        // إنشاء الدور
        $role = Role::create([
            'name' => $data['name'],
        ]);

        // إذا كان هناك صلاحيات
        if (! empty($data['permissions'])) {
            // تحويل IDs إلى كائنات Permission
            $permissions = Permission::whereIn('id', $data['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function updateRole(Role $role, array $data)
    {
        // تحديث اسم الدور
        $role->update([
            'name' => $data['name'],
        ]);

        // مزامنة الصلاحيات
        $permissions = ! empty($data['permissions'])
            ? Permission::whereIn('id', $data['permissions'])->get()
            : [];

        $role->syncPermissions($permissions);

        return $role;
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
    }
}
