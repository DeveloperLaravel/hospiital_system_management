<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $departmentService)
    {
        $this->middleware('permission:department-view')->only('index');
        $this->middleware('permission:department-create')->only('store');
        $this->middleware('permission:department-edit')->only('update');
        $this->middleware('permission:department-delete')->only('destroy');
    }

    public function index()
    {
        $departments = $this->departmentService->paginate();

        return view('hospital.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $this->departmentService->store($data);

        return back()->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $this->departmentService->update($department, $data);

        return back()->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Department $department)
    {
        $this->departmentService->delete($department);

        return back()->with('success', 'تم حذف القسم بنجاح');
    }
}
