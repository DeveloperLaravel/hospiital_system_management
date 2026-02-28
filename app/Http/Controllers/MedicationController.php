<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicationRequest;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:medications-view')->only('index');
        $this->middleware('permission:medications-create')->only(['create', 'store']);
        $this->middleware('permission:medications-edit')->only(['edit', 'update']);
        $this->middleware('permission:medications-delete')->only('destroy');
    }

    /**
     * عرض الصفحة + البحث + وضع التعديل
     */
    public function index()
    {
        $medications = Medication::latest()->paginate(10);

        return view('hospital.medications.index', compact('medications'));
    }

    public function create()
    {
        return view('medications.create');
    }

    public function store(MedicationRequest $request)
    {
        Medication::create($request->validated());

        return redirect()->route('medications.index')
            ->with('message', 'تم إضافة الدواء بنجاح!');
    }

    public function show(Medication $medication)
    {
        return view('hospital.medications.show', compact('medication'));
    }

    public function edit(Medication $medication)
    {
        return view('medications.edit', compact('medication'));
    }

    public function update(MedicationRequest $request, Medication $medication)
    {
        $medication->update($request->validated());

        return redirect()->route('medications.index')
            ->with('message', 'تم تحديث الدواء بنجاح!');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();

        return redirect()->route('medications.index')
            ->with('message', 'تم حذف الدواء بنجاح!');
    }
}
