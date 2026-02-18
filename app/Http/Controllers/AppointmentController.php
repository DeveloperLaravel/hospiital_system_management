<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;

        $this->middleware('permission:appointments.view')->only('index');
        $this->middleware('permission:appointments.create')->only(['create', 'store']);
        $this->middleware('permission:appointments.edit')->only(['edit', 'update']);
        $this->middleware('permission:appointments.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $appointments = $this->appointmentService->getAll($search);

        return view('hospital.appointments.index', compact('appointments', 'search'));
    }

    public function create()
    {
        return view('hospital.appointments.create', [
            'patients' => Patient::all(),
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
            'patients' => Patient::all(),
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
