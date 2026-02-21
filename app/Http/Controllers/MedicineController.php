<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:medicine-list')->only('index');
        $this->middleware('permission:medicine-create')->only('store');
        $this->middleware('permission:medicine-edit')->only('update');
        $this->middleware('permission:medicine-delete')->only('destroy');
    }

    public function index()
    {
        $medicines = Medication::latest()->get();

        return view('hospital.medication.index', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        Medication::create($request->all());

        return back()->with('success', 'Medicine created successfully');
    }

    public function update(Request $request, Medication $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $medicine->update($request->all());

        return back()->with('success', 'Medicine updated successfully');
    }

    public function destroy(Medication $medicine)
    {
        $medicine->delete();

        return back()->with('success', 'Medicine deleted successfully');
    }
}
