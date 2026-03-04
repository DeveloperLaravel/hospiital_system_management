<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionItemRequest;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use App\Services\PrescriptionItemService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrescriptionItemController extends Controller
{
    protected $service;

    public function __construct(PrescriptionItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'prescription_id', 'medication_id']);

        $items = $this->service->getAll($filters);
        $prescriptions = $this->service->getAvailablePrescriptions();
        $medications = $this->service->getAvailableMedications();

        return view('hospital.prescription_items.index', compact(
            'items', 'prescriptions', 'medications'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prescriptions = $this->service->getAvailablePrescriptions();
        $medications = $this->service->getAvailableMedications();

        return view('hospital.prescription_items.create', compact(
            'prescriptions', 'medications'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionItemRequest $request)
    {
        // Check if medication is already in prescription
        if ($this->service->isMedicationInPrescription(
            $request->prescription_id,
            $request->medication_id
        )) {
            return back()->with('error', 'هذا الدواء موجود بالفعل في الوصفة الطبية');
        }

        $this->service->create($request->validated());

        return redirect()->route('prescription-items.index')
            ->with('success', 'تم إضافة العنصر بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrescriptionItems $prescriptionItem)
    {
        $item = $this->service->getWithDetails($prescriptionItem);

        return view('hospital.prescription_items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrescriptionItems $prescriptionItem)
    {
        $item = $this->service->getById($prescriptionItem->id);
        $prescriptions = $this->service->getAvailablePrescriptions();
        $medications = $this->service->getAvailableMedications();

        return view('hospital.prescription_items.edit', compact(
            'item', 'prescriptions', 'medications'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionItemRequest $request, PrescriptionItems $prescriptionItems)
    {
        $this->service->update($prescriptionItems, $request->validated());

        return redirect()->route('prescription-items.index')
            ->with('success', 'تم تعديل العنصر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrescriptionItems $prescriptionItems)
    {
        $this->service->delete($prescriptionItems);

        return redirect()->route('prescription-items.index')
            ->with('success', 'تم حذف العنصر بنجاح');
    }

    /**
     * Export prescription items to PDF.
     */
    public function exportPdf(Prescription $prescription)
    {
        $items = $this->service->getByPrescription($prescription);

        // Load prescription with relationships
        $prescription->load(['medicalRecord.patient', 'doctor']);

        $pdf = Pdf::loadView('hospital.prescription_items.pdf', compact('prescription', 'items'));

        return $pdf->stream('prescription-'.$prescription->id.'.pdf');
    }

    /**
     * Export all patient prescriptions to PDF.
     */
    public function exportAllPrescriptionsPdf(Patient $patient)
    {
        // Load prescriptions with items and medications
        $prescriptions = $patient->prescriptions()
            ->with('items.medication')
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView(
            'hospital.prescription_items.all_prescriptions_pdf',
            compact('patient', 'prescriptions')
        );

        return $pdf->stream('all-prescriptions-'.$patient->id.'.pdf');
    }

    /**
     * Get prescription items grouped by prescription (API).
     */
    public function getByPrescription(Prescription $prescription)
    {
        $items = $this->service->getByPrescription($prescription);

        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    /**
     * Get prescription item details (API).
     */
    public function getDetails(PrescriptionItems $prescriptionItems)
    {
        $item = $this->service->getWithDetails($prescriptionItems);

        return response()->json([
            'success' => true,
            'item' => $item,
        ]);
    }

    /**
     * Check if medication exists in prescription (API).
     */
    public function checkMedication(Request $request)
    {
        $exists = $this->service->isMedicationInPrescription(
            $request->prescription_id,
            $request->medication_id
        );

        return response()->json([
            'success' => true,
            'exists' => $exists,
        ]);
    }
}
