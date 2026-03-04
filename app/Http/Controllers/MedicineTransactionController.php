<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineTransactionRequest;
use App\Models\Medication;
use App\Models\MedicineTransaction;
use App\Services\MedicineTransactionService;
use Illuminate\Http\Request;

class MedicineTransactionController extends Controller
{
    protected $service;

    public function __construct(MedicineTransactionService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'type', 'medication_id', 'start_date', 'end_date']);

        $transactions = $this->service->getAll($filters);
        $medications = $this->service->getAvailableMedications();
        $statistics = $this->service->getStatistics($filters);

        return view('hospital.medicine_transactions.index', compact(
            'transactions', 'medications', 'statistics'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medications = $this->service->getAvailableMedications();

        return view('hospital.medicine_transactions.create', compact('medications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineTransactionRequest $request)
    {
        // Check if sufficient stock for outbound
        if ($request->type === 'out') {
            $medication = Medication::find($request->medication_id);
            $currentStock = $medication->stock_quantity ?? 0;

            if ($currentStock < $request->quantity) {
                return back()->with('error', 'الكمية المتوفرة غير كافية. المتوفر: '.$currentStock);
            }
        }

        $this->service->create($request->validated());

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'تم إضافة الحركة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicineTransaction $medicineTransaction)
    {
        $transaction = $this->service->getWithDetails($medicineTransaction);

        return view('hospital.medicine_transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicineTransaction $medicineTransaction)
    {
        $transaction = $this->service->getById($medicineTransaction->id);
        $medications = $this->service->getAvailableMedications();

        return view('hospital.medicine_transactions.edit', compact('transaction', 'medications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineTransactionRequest $request, MedicineTransaction $medicineTransaction)
    {
        // Check if sufficient stock for outbound
        if ($request->type === 'out' && $request->medication_id === $medicineTransaction->medication_id) {
            $medication = Medication::find($request->medication_id);
            $currentStock = $medication->stock_quantity ?? 0;
            $diff = $request->quantity - $medicineTransaction->quantity;

            if ($currentStock < $diff) {
                return back()->with('error', 'الكمية المتوفرة غير كافية. المتوفر: '.$currentStock);
            }
        }

        $this->service->update($medicineTransaction, $request->validated());

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'تم تحديث الحركة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineTransaction $medicineTransaction)
    {
        $this->service->delete($medicineTransaction);

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'تم حذف الحركة بنجاح');
    }

    /**
     * Get transactions by medication (API).
     */
    public function getByMedication(Medication $medication)
    {
        $transactions = $this->service->getByMedication($medication);

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Get medication balance (API).
     */
    public function getBalance(Request $request)
    {
        $balance = $this->service->getMedicationBalance($request->medication_id);

        return response()->json([
            'success' => true,
            'balance' => $balance,
        ]);
    }

    /**
     * Get statistics (API).
     */
    public function getStatistics(Request $request)
    {
        $filters = $request->only(['medication_id', 'start_date', 'end_date']);
        $statistics = $this->service->getStatistics($filters);

        return response()->json([
            'success' => true,
            'statistics' => $statistics,
        ]);
    }
}
