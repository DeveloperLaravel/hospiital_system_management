<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);

        return view('hospital.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
        ]);

        Patient::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة المريض بنجاح');
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
        ]);

        $patient->update($request->all());

        return redirect()->back()->with('success', 'تم تعديل بيانات المريض بنجاح');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
    }
}
