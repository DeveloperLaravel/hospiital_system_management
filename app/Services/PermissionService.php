<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * استرجاع جميع الصلاحيات
     */
    public function all()
    {
        return Permission::all();
    }

    /**
     * إنشاء صلاحية جديدة
     */
    public function create(array $data): Permission
    {
        return Permission::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);
    }

    /**
     * تحديث صلاحية موجودة
     */
    public function update(Permission $permission, array $data): Permission
    {
        $permission->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);

        return $permission;
    }

    /**
     * حذف صلاحية
     */
    public function delete(Permission $permission): void
    {
        $permission->delete();
    }

    /**
     * إيجاد صلاحية بواسطة ID
     */
    public function find(int $id): ?Permission
    {
        return Permission::find($id);
    }
}
