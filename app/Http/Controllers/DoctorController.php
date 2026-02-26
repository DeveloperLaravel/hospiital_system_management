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
        // جلب الأطباء مع القسم وعمل Pagination
        $doctors = Doctor::with('department')->latest()->paginate(10);

        // جلب الأقسام لاستخدامها في الفورم
        $departments = Department::pluck('name', 'id');
        // إذا كان هناك طلب تعديل
        $editDoctor = null;
        if ($request->has('edit')) {
            $editDoctor = Doctor::find($request->edit);
        }

        return view('hospital.doctors.index', compact(
            'doctors',
            'departments',
            'editDoctor'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:100',
        ]);

        $this->doctorService->store($data);

        return redirect()->route('doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:100',
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
