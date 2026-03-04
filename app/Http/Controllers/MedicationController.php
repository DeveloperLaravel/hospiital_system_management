<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicationRequest;
use App\Models\Medication;
use App\Services\MedicationService;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    protected $medicationService;

    public function __construct(MedicationService $medicationService)
    {
        $this->medicationService = $medicationService;

        $this->middleware('permission:medications-view')->only('index');
        $this->middleware('permission:medications-create')->only(['create', 'store']);
        $this->middleware('permission:medications-edit')->only(['edit', 'update']);
        $this->middleware('permission:medications-delete')->only('destroy');
    }

    /**
     * Display a listing of medications with search
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $medications = $this->medicationService->search($search);
        } else {
            $medications = $this->medicationService->getAll();
        }

        // Get statistics
        $stats = $this->medicationService->getStats();

        return view('hospital.medications.index', compact('medications', 'stats', 'search'));
    }

    /**
     * Show the form for creating a new medication
     */
    public function create()
    {
        return view('hospital.medications.create');
    }

    /**
     * Store a newly created medication
     */
    public function store(MedicationRequest $request)
    {
        $this->medicationService->create($request->validated());

        return redirect()->route('medications.index')
            ->with('message', 'تم إضافة الدواء بنجاح!');
    }

    /**
     * Display the specified medication
     */
    public function show(Medication $medication)
    {
        return view('hospital.medications.show', compact('medication'));
    }

    /**
     * Show the form for editing the specified medication
     */
    public function edit(Medication $medication)
    {
        return view('hospital.medications.edit', compact('medication'));
    }

    /**
     * Update the specified medication
     */
    public function update(MedicationRequest $request, Medication $medication)
    {
        $this->medicationService->update($medication, $request->validated());

        return redirect()->route('medications.index')
            ->with('message', 'تم تحديث الدواء بنجاح!');
    }

    /**
     * Remove the specified medication
     */
    public function destroy(Medication $medication)
    {
        $this->medicationService->delete($medication);

        return redirect()->route('medications.index')
            ->with('message', 'تم حذف الدواء بنجاح!');
    }

    /**
     * Get low stock medications
     */
    public function lowStock()
    {
        $medications = $this->medicationService->getLowStock();

        return view('hospital.medications.low-stock', compact('medications'));
    }

    /**
     * Get expiring soon medications
     */
    public function expiringSoon()
    {
        $medications = $this->medicationService->getExpiringSoon();

        return view('hospital.medications.expiring-soon', compact('medications'));
    }
}
