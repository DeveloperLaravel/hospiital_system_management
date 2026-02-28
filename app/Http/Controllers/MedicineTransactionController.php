<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineTransactionRequest;
use App\Models\Medication;
use App\Models\MedicineTransaction;
use Illuminate\Http\Request;

class MedicineTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = MedicineTransaction::with(['medication', 'user'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('medication', fn ($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        return view('hospital.medicine_transactions.index', compact('transactions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(MedicineTransactionRequest $request)
    {
        MedicineTransaction::create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'Transaction added successfully!');
    }

    public function edit(MedicineTransaction $medicineTransaction)
    {
        $medications = Medication::all();

        return view('medicine_transactions.edit', compact('medicineTransaction', 'medications'));
    }

    public function update(MedicineTransactionRequest $request, MedicineTransaction $medicineTransaction)
    {
        $medicineTransaction->update($request->validated());

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy(MedicineTransaction $medicineTransaction)
    {
        $medicineTransaction->delete();

        return redirect()->route('medicine-transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}
