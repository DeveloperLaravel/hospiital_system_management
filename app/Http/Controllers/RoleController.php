<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;

        // حماية العمليات باستخدام صلاحيات Spatie
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->getAllRoles();
        $permissions = $this->roleService->getAllPermissions();
        $editRole = $request->editRole ? $this->roleService->getRoleById($request->editRole) : null;

        return view('system.roles.index', compact('roles', 'permissions', 'editRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $this->roleService->createRole($request->only(['name', 'permissions']));

        return redirect()->back()->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $this->roleService->updateRole($role, $request->only(['name', 'permissions']));

        return redirect()->back()->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy(Role $role)
    {

        $this->roleService->deleteRole($role);

        return redirect()->route('roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
