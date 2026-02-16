<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->paginate(10);

        return view('hospital.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('hospital.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'تم إنشاء القسم');
    }

    public function edit(Department $department)
    {
        return view('hospital.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'تم التحديث');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'تم الحذف');
    }
}
