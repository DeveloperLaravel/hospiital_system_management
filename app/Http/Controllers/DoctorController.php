<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;

        $this->middleware('permission:doctors-view')->only('index');
        $this->middleware('permission:doctors-create')->only(['create', 'store']);
        $this->middleware('permission:doctors-edit')->only(['edit', 'update']);
        $this->middleware('permission:doctors-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $doctors = $this->doctorService->getAll();
        $departments = Department::pluck('name', 'id');

        $editDoctor = null;

        if ($request->edit) {
            $editDoctor = $this->doctorService->find($request->edit);
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
        $data = $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'specialization' => 'required',
        ]);

        $this->doctorService->store($data);

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
        $data = $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'specialization' => 'required',
        ]);

        $this->doctorService->update($doctor, $data);

        return redirect()->route('doctors.index')
            ->with('success', 'تم تحديث بيانات الطبيب');
    }

    public function destroy(Doctor $doctor)
    {
        $this->doctorService->delete($doctor);

        return back()->with('success', 'تم حذف الطبيب');
    }
}
