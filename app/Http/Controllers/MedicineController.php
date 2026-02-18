<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:medicine-list')->only('index');
        $this->middleware('permission:medicine-create')->only(['create', 'store']);
        $this->middleware('permission:medicine-edit')->only(['edit', 'update']);
        $this->middleware('permission:medicine-delete')->only('destroy');
    }

    public function index()
    {
        $medicines = Medication::latest()->paginate(10);

        return view('hospital.medication.index', compact('medicines'));
    }

    public function create()
    {
        return view('hospital.medication.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'expiry_date' => 'nullable|date',
        ]);

        Medication::create($data);

        return redirect()->route('medication.index')->with('success', 'تمت الإضافة');
    }

    public function edit(Medication $medication)
    {
        return view('hospital.medication.form', compact('medication'));
    }

    public function update(Request $request, Medication $medication)
    {
        $data = $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'expiry_date' => 'nullable|date',
        ]);

        $medication->update($data);

        return redirect()->route('medicines.index')->with('success', 'تم التحديث');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();

        return back()->with('success', 'تم الحذف');
    }
}
