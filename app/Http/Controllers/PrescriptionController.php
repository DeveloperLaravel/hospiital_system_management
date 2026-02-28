<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $records = MedicalRecord::with('patient')->orderByDesc('id')->get();
        $doctors = User::where('role', 'doctor')->get();
        $medications = Medication::orderBy('name')->get();

        // AJAX load table
        if ($request->ajax) {
            $prescriptions = Prescription::with(['items.medication', 'medicalRecord.patient', 'doctor'])
                ->when($request->search, function ($q) use ($request) {
                    $q->whereHas('items.medication', function ($q2) use ($request) {
                        $q2->where('name', 'like', "%{$request->search}%");
                    });
                })
                ->latest()->paginate(10);

            return view('hospital.prescriptions.partials.table', compact('records', 'doctors', 'medications'))->render();
        }

        return view('hospital.prescriptions.index', compact(
            'prescriptions',
        ));
    }

    public function create()
    {
        $medicalRecords = MedicalRecord::with('patient')->orderByDesc('id')->get();
        $doctors = User::where('role', 'doctor')->get();
        $medications = Medication::orderBy('name')->get();

        return view('prescriptions.create', compact('medicalRecords', 'doctors', 'medications'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'doctor_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string|max:255',
            'items.*.frequency' => 'required|string|max:255',
            'items.*.duration' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $prescription = Prescription::create([
                'medical_record_id' => $data['medical_record_id'],
                'doctor_id' => $data['doctor_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $prescription->items()->create($item);
            }
        });

        return response()->json(['message' => 'تم حفظ الوصفة بنجاح']);
    }

    public function show(Prescription $prescription, Request $request)
    {
        $prescription->load('items.medication', 'medicalRecord.patient', 'doctor');

        if ($request->print) {
            return view('hospital.prescriptions.print', compact('prescription'));
        }

        return response()->json($prescription);
    }

    // public function edit(Prescription $prescription)
    // {
    //     $medicalRecords = MedicalRecord::with('patient')->orderByDesc('id')->get();
    //     $doctors = User::where('role', 'doctor')->get();
    //     $medications = Medication::orderBy('name')->get();

    //     $prescription->load('items');

    //     return view('prescriptions.edit', compact('prescription', 'medicalRecords', 'doctors', 'medications'));
    // }

    public function update(Request $request, Prescription $prescription)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'doctor_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string|max:255',
            'items.*.frequency' => 'required|string|max:255',
            'items.*.duration' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data, $prescription) {
            $prescription->update([
                'medical_record_id' => $data['medical_record_id'],
                'doctor_id' => $data['doctor_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            $prescription->items()->delete();

            foreach ($data['items'] as $item) {
                $prescription->items()->create($item);
            }
        });

        return response()->json(['message' => 'تم تحديث الوصفة بنجاح']);
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return response()->json(['message' => 'تم حذف الوصفة بنجاح']);
    }
}
