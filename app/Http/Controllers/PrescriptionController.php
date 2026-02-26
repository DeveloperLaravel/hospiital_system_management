<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $prescriptions = Prescription::with([
            'medication:id,name',
            'medicalRecord.patient:id,name',
        ])
            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('medication', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%");
                });

            })
            ->latest()
            ->paginate(10);

        // مهم جداً لعرض المرضى في modal
        $records = MedicalRecord::with('patient:id,name')
            ->orderByDesc('id')
            ->get();
        // $records = MedicalRecord::with('patient')
        //     ->whereHas('patient')
        //     ->get();

        $medications = Medication::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('hospital.prescriptions.index', compact(
            'prescriptions',
            'records',
            'medications'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
        ]);

        Prescription::create($data);

        return back()->with('success', 'تم إضافة الوصفة بنجاح');
    }

    public function update(Request $request, Prescription $prescription)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
        ]);

        $prescription->update($data);

        return back()->with('success', 'تم تحديث الوصفة');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return back()->with('success', 'تم حذف الوصفة');
    }
}
