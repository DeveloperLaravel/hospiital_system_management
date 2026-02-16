<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $roles = Role::all();

        return view('system.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('system.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
            ],
            [
                'name.required' => 'يرجى إدخال اسم الدور.',
                'name.unique' => 'اسم الدور موجود بالفعل.',
                'permissions.required' => 'يجب اختيار صلاحية واحدة على الأقل.',
                'permissions.array' => 'قيمة الصلاحيات غير صحيحة.',
            ],
            [
                'name' => 'اسم الدور',
                'permissions' => 'الصلاحيات',
            ]
        );

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('system.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(
            [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
            ],
            [
                'name.required' => 'يرجى إدخال اسم الدور.',
                'name.unique' => 'اسم الدور موجود بالفعل.',
                'permissions.required' => 'يجب اختيار صلاحية واحدة على الأقل.',
                'permissions.array' => 'قيمة الصلاحيات غير صحيحة.',
            ],
            [
                'name' => 'اسم الدور',
                'permissions' => 'الصلاحيات',
            ]
        );

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
