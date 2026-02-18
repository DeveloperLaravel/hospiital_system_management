<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('permission:permission-list|permission-view', ['only' => ['index']]);
        $this->middleware('permission:permission-create', ['only' => ['store']]);
        $this->middleware('permission:permission-edit', ['only' => ['update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * عرض جميع الصلاحيات
     */
    public function index()
    {
        $permissions = $this->permissionService->all();

        return view('system.permissions.index', compact('permissions'));
    }

    /**
     * إنشاء صلاحية جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->permissionService->create($request->only('name'));

        return redirect()->back()->with('success', 'تم إنشاء الصلاحية بنجاح');
    }

    /**
     * تحديث صلاحية موجودة
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission = $this->permissionService->find($id);
        if (! $permission) {
            return redirect()->back()->with('error', 'الصلاحية غير موجودة');
        }

        $this->permissionService->update($permission, $request->only('name'));

        return redirect()->back()->with('success', 'تم تحديث الصلاحية بنجاح');
    }

    /**
     * حذف صلاحية
     */
    public function destroy($id)
    {
        $permission = $this->permissionService->find($id);
        if (! $permission) {
            return redirect()->back()->with('error', 'الصلاحية غير موجودة');
        }

        $this->permissionService->delete($permission);

        return redirect()->back()->with('success', 'تم حذف الصلاحية بنجاح');
    }
}
