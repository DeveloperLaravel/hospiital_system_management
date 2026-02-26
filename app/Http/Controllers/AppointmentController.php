<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Services\AppointmentService;
use App\Services\PatientService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    protected $patientService;

    public function __construct(AppointmentService $appointmentService, PatientService $patientService)
    {
        $this->appointmentService = $appointmentService;
        $this->patientService = $patientService;

        $this->middleware('permission:appointments-view')->only('index');
        $this->middleware('permission:appointments-create')->only(['create', 'store']);
        $this->middleware('permission:appointments-edit')->only(['edit', 'update']);
        $this->middleware('permission:appointments-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        // $search = $request->query('search');

        // $appointments = $this->appointmentService->getAll($search);
        $search = $request->input('search');

        $appointments = Appointment::with(['patient', 'doctor'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('patient', fn ($q) => $q->where('name', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        // المرضى الذين لا يملكون موعد بالفعل
        $takenPatientIds = Appointment::pluck('patient_id')->toArray();
        $patients = Patient::whereNotIn('id', $takenPatientIds)->get();

        $doctors = Doctor::all();

        return view('hospital.appointments.index', compact('appointments', 'patients', 'doctors', 'search'));
    }

    public function create()
    {
        return view('hospital.appointments.create', [
            'patients' => \App\Models\Patient::orderBy('name', 'asc')->get(),
            'doctors' => Doctor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAppointment($request);

        $this->appointmentService->create($validated);

        return redirect()->route('appointments.index')
            ->with('message', 'تم إضافة الموعد بنجاح');
    }

    public function edit(Appointment $appointment)
    {
        return view('hospital.appointments.create', [
            'appointment' => $appointment,
            'patients' => \App\Models\Patient::orderBy('name', 'asc')->get(),
            'doctors' => Doctor::all(),
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $this->validateAppointment($request);

        $this->appointmentService->update($appointment, $validated);

        return redirect()->route('appointments.index')
            ->with('message', 'تم تحديث الموعد بنجاح');
    }

    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment);

        return redirect()->route('appointments.index')
            ->with('message', 'تم حذف الموعد بنجاح');
    }

    private function validateAppointment(Request $request)
    {
        return $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
    }
}
