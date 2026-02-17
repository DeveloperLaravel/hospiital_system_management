<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view doctors')->only('index');
        $this->middleware('permission:create doctors')->only(['create', 'store']);
        $this->middleware('permission:edit doctors')->only(['edit', 'update']);
        $this->middleware('permission:delete doctors')->only('destroy');
    }

    public function index(Request $request)
    {
        $doctors = Doctor::with('department')->get();
        $departments = Department::pluck('name', 'id');

        $editDoctor = null;

        if ($request->edit) {
            $editDoctor = Doctor::find($request->edit);
        }

        return view('hospital.doctors.index', compact(
            'doctors',
            'departments',
            'editDoctor'
        ));
    }

    public function create()
    {
        $departments = Department::pluck('name', 'id');

        return view('hospital.doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'specialization' => 'required',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::pluck('name', 'id');

        return view('hospital.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'specialization' => 'required',
        ]);

        $doctor->update($request->all());

        return redirect()->route('doctors.index')
            ->with('success', 'تم تحديث بيانات الطبيب');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return back()->with('success', 'تم حذف الطبيب');
    }
}
