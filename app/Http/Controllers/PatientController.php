<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
        $this->middleware('permission:permission-list|permission-view', ['only' => ['index']]);
        $this->middleware('permission:permission-create', ['only' => ['store']]);
        $this->middleware('permission:permission-edit', ['only' => ['update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    // عرض قائمة المرضى
    public function index()
    {
        $patients = $this->patientService->getAllPatients();

        return view('hospital.patients.index', compact('patients'));
    }

    // إنشاء مريض جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
        ]);

        $this->patientService->createPatient($validated);

        return redirect()->back()->with('success', 'تم إضافة المريض بنجاح');
    }

    // تحديث بيانات مريض
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
        ]);

        $this->patientService->updatePatient($patient, $validated);

        return redirect()->back()->with('success', 'تم تعديل بيانات المريض بنجاح');
    }

    // حذف المريض
    public function destroy(Patient $patient)
    {
        $this->patientService->deletePatient($patient);

        return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
    }
}
