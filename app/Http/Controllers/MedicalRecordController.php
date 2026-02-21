<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;

        $this->middleware('permission:medical-records-view')->only('index');
        $this->middleware('permission:medical-records-create')->only('store');
        $this->middleware('permission:medical-records-edit')->only('update');
        $this->middleware('permission:medical-records-delete')->only('destroy');
    }

    public function index()
    {
        $records = $this->medicalRecordService->getAll();
        $patients = $this->medicalRecordService->getPatients();
        $doctors = $this->medicalRecordService->getDoctors();

        return view('hospital.medical_records.index', compact('records', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $this->medicalRecordService->store($validated);

        return back()->with('success', 'تم الإضافة');
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $this->medicalRecordService->update($medicalRecord, $validated);

        return back()->with('success', 'تم التعديل');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->medicalRecordService->delete($medicalRecord);

        return back()->with('success', 'تم الحذف');
    }
}
