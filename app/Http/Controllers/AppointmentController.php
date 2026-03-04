<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
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

        $this->middleware('permission:appointments-view')->only(['index', 'show']);
        $this->middleware('permission:appointments-create')->only(['create', 'store']);
        $this->middleware('permission:appointments-edit')->only(['edit', 'update']);
        $this->middleware('permission:appointments-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $appointments = $this->appointmentService->getAllAppointments($search);
        $patients = $this->appointmentService->getAvailablePatients();
        $doctors = $this->appointmentService->getAllDoctors();

        return view('hospital.appointments.index', compact('appointments', 'patients', 'doctors', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = $this->appointmentService->getAvailablePatients();
        $doctors = $this->appointmentService->getAllDoctors();

        return view('hospital.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        // Check for conflicts
        if ($this->appointmentService->hasConflict(
            $request->doctor_id,
            $request->date,
            $request->time
        )) {
            return redirect()->back()
                ->with('error', 'يوجد موعد آخر للطبيب في نفس الوقت والتاريخ')
                ->withInput();
        }

        if ($this->appointmentService->hasPatientConflict(
            $request->patient_id,
            $request->date,
            $request->time
        )) {
            return redirect()->back()
                ->with('error', 'المريض لديه موعد آخر في نفس الوقت والتاريخ')
                ->withInput();
        }

        $this->appointmentService->create($request->validated());

        return redirect()->route('appointments.index')
            ->with('message', 'تم إضافة الموعد بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();

        return view('hospital.appointments.create', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        // Check for conflicts excluding current appointment
        if ($this->appointmentService->hasConflict(
            $request->doctor_id,
            $request->date,
            $request->time,
            $appointment->id
        )) {
            return redirect()->back()
                ->with('error', 'يوجد موعد آخر للطبيب في نفس الوقت والتاريخ')
                ->withInput();
        }

        if ($this->appointmentService->hasPatientConflict(
            $request->patient_id,
            $request->date,
            $request->time,
            $appointment->id
        )) {
            return redirect()->back()
                ->with('error', 'المريض لديه موعد آخر في نفس الوقت والتاريخ')
                ->withInput();
        }

        $this->appointmentService->update($appointment, $request->validated());

        return redirect()->route('appointments.index')
            ->with('message', 'تم تحديث الموعد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment);

        return redirect()->route('appointments.index')
            ->with('message', 'تم حذف الموعد بنجاح');
    }

    /**
     * Confirm an appointment
     */
    public function confirm(Appointment $appointment)
    {
        if (! $appointment->canEdit()) {
            return redirect()->back()
                ->with('error', 'لا يمكن تأكيد هذا الموعد');
        }

        $this->appointmentService->confirm($appointment);

        return redirect()->route('appointments.index')
            ->with('message', 'تم تأكيد الموعد بنجاح');
    }

    /**
     * Complete an appointment
     */
    public function complete(Appointment $appointment)
    {
        $this->appointmentService->complete($appointment);

        return redirect()->route('appointments.index')
            ->with('message', 'تم إكمال الموعد بنجاح');
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Appointment $appointment)
    {
        if (! $appointment->canCancel()) {
            return redirect()->back()
                ->with('error', 'لا يمكن إلغاء هذا الموعد');
        }

        $this->appointmentService->cancel($appointment);

        return redirect()->route('appointments.index')
            ->with('message', 'تم إلغاء الموعد بنجاح');
    }
}
