<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrescriptionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PrescriptionItems::with(['prescription', 'medication'])
            ->latest()->paginate(10);

        $prescriptions = Prescription::all();
        $medications = Medication::all();

        return view('hospital.prescription_items.index', compact(
            'items', 'prescriptions', 'medications'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'duration' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
        ]);

        PrescriptionItems::create($validated);

        return back()->with('message', 'تم إضافة العنصر بنجاح');
    }

    public function update(Request $request, PrescriptionItems $prescriptionItems)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'duration' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
        ]);

        $prescriptionItems->update($validated);

        return back()->with('message', 'تم تعديل العنصر بنجاح');
    }

    public function destroy(PrescriptionItems $prescriptionItems)
    {
        $prescriptionItems->delete();

        return back()->with('message', 'تم حذف العنصر');
    }

    public function exportPdf(Prescription $prescription)
    {
        $items = $prescription->items()->with('medication')->get();

        $pdf = Pdf::loadView('prescription_items.pdf', compact('prescription', 'items'));

        return $pdf->stream('prescription-'.$prescription->id.'.pdf');
    }

    public function exportAllPrescriptionsPdf(Patient $patient)
    {
        // جلب جميع وصفات المريض مع العناصر والأدوية
        $prescriptions = $patient->prescriptions()
            ->with('items.medication')
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView(
            'prescription_items.all_prescriptions_pdf',
            compact('patient', 'prescriptions')
        );

        return $pdf->stream('all-prescriptions-'.$patient->id.'.pdf');
    }
}
