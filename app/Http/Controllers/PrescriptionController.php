<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    protected $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;

        $this->middleware('permission:prescriptions-view')->only('index', 'show');
        $this->middleware('permission:prescriptions-create')->only('create', 'store');
        $this->middleware('permission:prescriptions-edit')->only('edit', 'update');
        $this->middleware('permission:prescriptions-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $prescriptions = Prescription::withRelations()
            ->search($search)
            ->latest()
            ->paginate(10);

        $medicalRecords = MedicalRecord::with('patient')->orderByDesc('id')->get();
        $doctors = Doctor::all();
        $medications = Medication::orderBy('name')->get();

        return view('hospital.prescriptions.index', compact(
            'prescriptions',
            'medicalRecords',
            'doctors',
            'medications',
            'search'
        ));
    }

    public function create()
    {
        $medicalRecords = MedicalRecord::with('patient')->orderByDesc('id')->get();
        $doctors = Doctor::all();
        $medications = Medication::orderBy('name')->get();

        return view('hospital.prescriptions.create', compact('medicalRecords', 'doctors', 'medications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string|max:255',
            'items.*.frequency' => 'required|string|max:255',
            'items.*.duration' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string|max:255',
        ]);

        $this->prescriptionService->create($validated);

        return redirect()->route('prescriptions.index')
            ->with('message', 'تم إضافة الوصفة الطبية بنجاح');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('items.medication', 'medicalRecord.patient', 'doctor');

        return view('hospital.prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $medicalRecords = MedicalRecord::with('patient')->orderByDesc('id')->get();
        $doctors = Doctor::all();
        $medications = Medication::orderBy('name')->get();

        $prescription->load('items');

        return view('hospital.prescriptions.edit', compact('prescription', 'medicalRecords', 'doctors', 'medications'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string|max:255',
            'items.*.frequency' => 'required|string|max:255',
            'items.*.duration' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string|max:255',
        ]);

        $this->prescriptionService->update($prescription, $validated);

        return redirect()->route('prescriptions.index')
            ->with('message', 'تم تحديث الوصفة الطبية بنجاح');
    }

    public function destroy(Prescription $prescription)
    {
        $this->prescriptionService->delete($prescription);

        return redirect()->route('prescriptions.index')
            ->with('message', 'تم حذف الوصفة الطبية بنجاح');
    }

    public function print(Prescription $prescription)
    {
        $prescription->load('items.medication', 'medicalRecord.patient', 'doctor');

        return view('hospital.prescriptions.print', compact('prescription'));
    }
}
