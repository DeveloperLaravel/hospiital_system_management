<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:medical_records.view')->only('index');
        $this->middleware('permission:medical_records.create')->only('store');
        $this->middleware('permission:medical_records.edit')->only('update');
        $this->middleware('permission:medical_records.delete')->only('destroy');
    }

    public function index()
    {
        $records = MedicalRecord::with(['patient', 'doctor'])
            ->latest()
            ->paginate(5); // pagination
        $patients = Patient::all();
        $doctors = Doctor::with('department')->get();

        return view('hospital.medical_records.index', compact('records', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
        ]);

        MedicalRecord::create($request->all());

        return back()->with('success', 'تم الإضافة');
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->all());

        return back()->with('success', 'تم التعديل');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return back()->with('success', 'تم الحذف');
    }
}
