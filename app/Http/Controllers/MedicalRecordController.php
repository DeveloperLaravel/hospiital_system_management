<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalRecordRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\MedicalRecordService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;

        $this->middleware('permission:medical-records-view')->only(['index', 'show', 'history']);
        $this->middleware('permission:medical-records-create')->only(['store', 'create']);
        $this->middleware('permission:medical-records-edit')->only(['edit', 'update']);
        $this->middleware('permission:medical-records-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = MedicalRecord::with(['patient:id,name', 'doctor:id,name'])
            ->when($request->search, function ($q) use ($request) {
                $q->search($request->search);
            })
            ->latestFirst()
            ->paginate(10);

        $patients = Patient::pluck('name', 'id');
        $doctors = Doctor::pluck('name', 'id');

        return view('hospital.medical_records.index', compact('records', 'patients', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::pluck('name', 'id');
        $doctors = Doctor::pluck('name', 'id');
        $appointments = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->with(['patient', 'doctor'])
            ->get();

        return view('hospital.medical_records.create', compact('patients', 'doctors', 'appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalRecordRequest $request)
    {
        $this->medicalRecordService->create($request->validated());

        return redirect()->route('medical-records.index')
            ->with('success', 'تم إضافة السجل الطبي بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medical_record)
    {
        $medical_record->load(['patient', 'doctor', 'prescriptions.medication']);

        return view('hospital.medical_records.show', compact('medical_record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medical_record)
    {
        $patients = Patient::pluck('name', 'id');
        $doctors = Doctor::pluck('name', 'id');

        return view('hospital.medical_records.edit', compact('medical_record', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalRecordRequest $request, MedicalRecord $medical_record)
    {
        $this->medicalRecordService->update($medical_record, $request->validated());

        return redirect()->route('medical-records.index')
            ->with('success', 'تم تحديث السجل الطبي بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medical_record)
    {
        $this->medicalRecordService->delete($medical_record);

        return redirect()->route('medical-records.index')
            ->with('success', 'تم حذف السجل الطبي بنجاح');
    }

    /**
     * Display patient's medical history.
     */
    public function history(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with('doctor')
            ->latestFirst()
            ->get();

        return view('hospital.medical_records.history', compact('patient', 'records'));
    }

    /**
     * Generate PDF for patient's medical history.
     */
    public function historyPdf(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with('doctor')
            ->latestFirst()
            ->get();

        $pdf = Pdf::loadView('hospital.medical_records.history_pdf', compact('patient', 'records'));

        return $pdf->download('medical-history-'.$patient->id.'.pdf');
    }
}
