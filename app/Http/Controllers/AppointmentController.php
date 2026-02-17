<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view appointments')->only('index');
        $this->middleware('permission:create appointments')->only(['create', 'store']);
        $this->middleware('permission:edit appointments')->only(['edit', 'update']);
        $this->middleware('permission:delete appointments')->only('destroy');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereHas('patient', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(5);

        return view('hospital.appointments.index', compact('appointments', 'search'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        // $patients = User::role('patient')->get();
        // $doctors = User::role('doctor')->get();

        return view('hospital.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ], [
            'patient_id.required' => 'اختر المريض',
            'doctor_id.required' => 'اختر الطبيب',
            'date.required' => 'حدد تاريخ الموعد',
            'time.required' => 'حدد وقت الموعد',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('message', 'تم إضافة الموعد بنجاح');
    }

    public function edit(Appointment $appointment)
    {
        // $patients = User::role('patient')->get();
        // $doctors = User::role('doctor')->get();
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('hospital.appointments.create', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('message', 'تم تحديث الموعد بنجاح');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('message', 'تم حذف الموعد بنجاح');
    }
}
