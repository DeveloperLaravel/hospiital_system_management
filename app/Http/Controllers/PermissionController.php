<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->get();

        return view('system.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('system.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            ['name' => 'required|unique:permissions,name'],
            ['name.required' => 'يرجى إدخال اسم الصلاحية']
        );

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'تم إنشاء الصلاحية بنجاح');
    }

    public function edit(Permission $permission)
    {
        return view('system.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(
            ['name' => 'required|unique:permissions,name,'.$permission->id],
            ['name.required' => 'يرجى إدخال اسم الصلاحية']
        );

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'تم تحديث الصلاحية');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'تم حذف الصلاحية');
    }
}
