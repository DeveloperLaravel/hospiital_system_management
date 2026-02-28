<?php

namespace App\Http\Controllers;

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
        // $this->medicalRecordService = $medicalRecordService;

        $this->middleware('permission:medical-records-view')->only('index');
        $this->middleware('permission:medical-records-create')->only('store');
        $this->middleware('permission:medical-records-edit')->only('update');
        $this->middleware('permission:medical-records-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        // $records = $this->medicalRecordService->getAll();
        // $patients = $this->medicalRecordService->getPatients();
        // $doctors = $this->medicalRecordService->getDoctors();
        // $records = MedicalRecord::with([
        //     'patient',
        //     'doctor',
        //     'appointment',
        // ])->latest()->paginate(10);

        // $patients = Patient::all();
        // $doctors = Doctor::all();
        // $appointments = Appointment::all();
        $records = MedicalRecord::with([
            'patient:id,name',
            'doctor:id,name',
        ])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('patient', fn ($qq) => $qq->where('name', 'like', "%{$request->search}%")
                )
                    ->orWhereHas('doctor', fn ($qq) => $qq->where('name', 'like', "%{$request->search}%")
                    )
                    ->orWhere('diagnosis', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        $patients = Patient::pluck('name', 'id');
        $doctors = Doctor::pluck('name', 'id');

        return view('hospital.medical_records.index', compact('records', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'visit_date' => 'nullable|date',
            'diagnosis' => 'nullable',
            'treatment' => 'nullable',
            'notes' => 'nullable',
        ]);

        MedicalRecord::create($data);

        return back()->with('success', 'تم إضافة السجل بنجاح');
    }

    public function update(Request $request, MedicalRecord $medical_record)
    {
        $data = $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'visit_date' => 'nullable|date',
            'diagnosis' => 'nullable',
            'treatment' => 'nullable',
            'notes' => 'nullable',
        ]);

        $medical_record->update($data);

        return back()->with('success', 'تم التحديث');
    }

    public function destroy(MedicalRecord $medical_record)
    {
        $medical_record->delete();

        return back()->with('success', 'تم الحذف');
    }

    public function show(MedicalRecord $medical_record)
    {
        $medical_record->load([
            'patient',
            'doctor',
            'prescriptions.medication',
        ]);

        return view('hospital.medical_records.show', compact('medical_record'));
    }

    public function history(Patient $patient)
    {
        $records = $patient
            ->medicalRecords()
            ->with('doctor')
            ->orderByDesc('visit_date')
            ->get();

        return view(
            'hospital.medical_records.history',
            compact('patient', 'records')
        );
    }

    public function historyPdf(Patient $patient)
    {
        $records = $patient
            ->medicalRecords()
            ->with('doctor')
            ->orderByDesc('visit_date')
            ->get();

        $pdf = Pdf::loadView(
            'medical_records.history_pdf',
            compact('patient', 'records')
        );

        return $pdf->download(
            'medical-history-'.$patient->id.'.pdf'
        );

        // return $pdf->stream(
        //     'medical-history-'.$patient->id.'.pdf'
        // );
    }
}
