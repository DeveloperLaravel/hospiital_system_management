<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AppointmentManager extends Component
{
    use WithFileUploads, WithPagination;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $appointmentId = null;

    public $viewMode = 'table'; // table, calendar

    // Form fields
    public $patient_id = '';

    public $doctor_id = '';

    public $date = '';

    public $time = '';

    public $status = 'pending';

    public $notes = '';

    // Additional fields
    public $appointment_type = 'checkup';

    public $is_emergency = false;

    public $duration = 30; // minutes

    // Searchable dropdowns
    public $patientSearch = '';

    public $doctorSearch = '';

    public $showPatientDropdown = false;

    public $showDoctorDropdown = false;

    // Filters
    public $filterStatus = '';

    public $filterDate = '';

    public $filterDoctor = '';

    public $filterPatient = '';

    public $dateRangeStart = '';

    public $dateRangeEnd = '';

    // Bulk selection
    public $selectedAppointments = [];

    public $selectAll = false;

    // Validation rules
    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
        'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
        'notes' => 'nullable|string|max:1000',
        'appointment_type' => 'nullable|in:checkup,followup,emergency,consultation',
        'is_emergency' => 'boolean',
        'duration' => 'nullable|integer|min:15|max:180',
    ];

    // Status labels
    public $statusLabels = [
        'pending' => 'قيد الانتظار',
        'confirmed' => 'مؤكد',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'no_show' => 'لم يحضر',
    ];

    // Appointment types
    public $appointmentTypes = [
        'checkup' => 'فحص عام',
        'followup' => 'متابعة',
        'emergency' => 'طوارئ',
        'consultation' => 'استشارة',
    ];

    // Time slots
    public $timeSlots = [];

    public function mount()
    {
        $this->generateTimeSlots();
    }

    // Generate time slots
    public function generateTimeSlots()
    {
        $this->timeSlots = [];
        $startTime = strtotime('08:00');
        $endTime = strtotime('20:00');

        while ($startTime <= $endTime) {
            $this->timeSlots[] = date('H:i', $startTime);
            $startTime += 30 * 60; // 30 minutes interval
        }
    }

    // Real-time search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterDate()
    {
        $this->resetPage();
    }

    public function updatedFilterDoctor()
    {
        $this->resetPage();
    }

    public function updatedFilterPatient()
    {
        $this->resetPage();
    }

    public function updatedPatientSearch()
    {
        $this->showPatientDropdown = true;
    }

    public function updatedDoctorSearch()
    {
        $this->showDoctorDropdown = true;
    }

    public function selectPatient($patientId)
    {
        $this->patient_id = $patientId;
        $patient = Patient::find($patientId);
        $this->patientSearch = $patient ? $patient->name : '';
        $this->showPatientDropdown = false;
    }

    public function selectDoctor($doctorId)
    {
        $this->doctor_id = $doctorId;
        $doctor = Doctor::find($doctorId);
        $this->doctorSearch = $doctor ? $doctor->name : '';
        $this->showDoctorDropdown = false;
    }

    // Get filtered patients for dropdown
    public function getFilteredPatients()
    {
        return Patient::when($this->patientSearch, function ($query) {
            $query->where('name', 'like', '%'.$this->patientSearch.'%');
        })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
    }

    // Get filtered doctors for dropdown
    public function getFilteredDoctors()
    {
        return Doctor::when($this->doctorSearch, function ($query) {
            $query->where('name', 'like', '%'.$this->doctorSearch.'%');
        })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
    }

    // Get available time slots for selected doctor and date
    public function getAvailableTimeSlots()
    {
        if (! $this->doctor_id || ! $this->date) {
            return $this->timeSlots;
        }

        $bookedSlots = Appointment::where('doctor_id', $this->doctor_id)
            ->where('date', $this->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time')
            ->toArray();

        return array_filter($this->timeSlots, function ($slot) use ($bookedSlots) {
            return ! in_array($slot, $bookedSlots);
        });
    }

    // Render the view
    public function render()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    })->orWhereHas('doctor', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('date', $this->filterDate);
            })
            ->when($this->filterDoctor, function ($query) {
                $query->where('doctor_id', $this->filterDoctor);
            })
            ->when($this->filterPatient, function ($query) {
                $query->where('patient_id', $this->filterPatient);
            })
            ->when($this->dateRangeStart, function ($query) {
                $query->whereDate('date', '>=', $this->dateRangeStart);
            })
            ->when($this->dateRangeEnd, function ($query) {
                $query->whereDate('date', '<=', $this->dateRangeEnd);
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(15);

        // Get patients and doctors for dropdowns
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();

        // Statistics
        $stats = $this->getStatistics();

        // Calendar data
        $calendarAppointments = $this->getCalendarAppointments();

        return view('livewire.appointment-manager', [
            'appointments' => $appointments,
            'patients' => $patients,
            'doctors' => $doctors,
            'stats' => $stats,
            'calendarAppointments' => $calendarAppointments,
            'filteredPatients' => $this->getFilteredPatients(),
            'filteredDoctors' => $this->getFilteredDoctors(),
            'availableTimeSlots' => $this->getAvailableTimeSlots(),
        ]);
    }

    // Get statistics
    public function getStatistics()
    {
        return [
            'total' => Appointment::count(),
            'pending' => Appointment::pending()->count(),
            'confirmed' => Appointment::confirmed()->count(),
            'completed' => Appointment::completed()->count(),
            'cancelled' => Appointment::cancelled()->count(),
            'today' => Appointment::today()->count(),
            'this_week' => Appointment::whereBetween('date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])->count(),
            'this_month' => Appointment::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
        ];
    }

    // Get calendar appointments
    public function getCalendarAppointments()
    {
        return Appointment::with(['patient', 'doctor'])
            ->where('date', '>=', now()->toDateString())
            ->where('date', '<=', now()->addDays(30)->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('date')
            ->orderBy('time')
            ->get();
    }

    // Open modal for creating
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    // Open modal for editing
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->appointmentId = $appointment->id;
        $this->patient_id = $appointment->patient_id;
        $this->doctor_id = $appointment->doctor_id;
        $this->date = $appointment->date;
        $this->time = $appointment->time;
        $this->status = $appointment->status;
        $this->notes = $appointment->notes ?? '';
        $this->appointment_type = $appointment->appointment_type ?? 'checkup';
        $this->is_emergency = $appointment->is_emergency ?? false;
        $this->duration = $appointment->duration ?? 30;

        // Set search values
        $patient = Patient::find($this->patient_id);
        $this->patientSearch = $patient ? $patient->name : '';

        $doctor = Doctor::find($this->doctor_id);
        $this->doctorSearch = $doctor ? $doctor->name : '';

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    // Close modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->showPatientDropdown = false;
        $this->showDoctorDropdown = false;
        $this->resetForm();
    }

    // Reset form fields
    public function resetForm()
    {
        $this->appointmentId = null;
        $this->patient_id = '';
        $this->doctor_id = '';
        $this->date = '';
        $this->time = '';
        $this->status = 'pending';
        $this->notes = '';
        $this->patientSearch = '';
        $this->doctorSearch = '';
        $this->appointment_type = 'checkup';
        $this->is_emergency = false;
        $this->duration = 30;
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        // Check for doctor conflict
        $doctorConflict = Appointment::where('doctor_id', $this->doctor_id)
            ->where('date', $this->date)
            ->where('time', $this->time)
            ->when($this->appointmentId, function ($query) {
                $query->where('id', '!=', $this->appointmentId);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($doctorConflict) {
            session()->flash('error', 'يوجد موعد آخر للطبيب في نفس الوقت والتاريخ');

            return;
        }

        // Check for patient conflict
        $patientConflict = Appointment::where('patient_id', $this->patient_id)
            ->where('date', $this->date)
            ->where('time', $this->time)
            ->when($this->appointmentId, function ($query) {
                $query->where('id', '!=', $this->appointmentId);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($patientConflict) {
            session()->flash('error', 'المريض لديه موعد آخر في نفس الوقت والتاريخ');

            return;
        }

        $data = [
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'notes' => $this->notes ?: null,
            'appointment_type' => $this->appointment_type,
            'is_emergency' => $this->is_emergency,
            'duration' => $this->duration,
        ];

        if ($this->isEditMode && $this->appointmentId) {
            $appointment = Appointment::findOrFail($this->appointmentId);
            $appointment->update($data);
            session()->flash('success', 'تم تحديث الموعد بنجاح');
        } else {
            Appointment::create($data);
            session()->flash('success', 'تمت إضافة الموعد بنجاح');
        }

        $this->closeModal();
    }

    // Delete appointment
    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        session()->flash('success', 'تم حذف الموعد بنجاح');
    }

    // Bulk delete
    public function bulkDelete()
    {
        if (empty($this->selectedAppointments)) {
            session()->flash('error', 'يرجى تحديد مواعيد للحذف');

            return;
        }

        Appointment::whereIn('id', $this->selectedAppointments)->delete();
        $this->selectedAppointments = [];
        $this->selectAll = false;
        session()->flash('success', 'تم حذف المواعيد المحددة بنجاح');
    }

    // Bulk update status
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedAppointments)) {
            session()->flash('error', 'يرجى تحديد مواعيد للتحديث');

            return;
        }

        Appointment::whereIn('id', $this->selectedAppointments)->update(['status' => $status]);
        $this->selectedAppointments = [];
        $this->selectAll = false;
        session()->flash('success', 'تم تحديث حالة المواعيد المحددة بنجاح');
    }

    // Quick actions
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $appointment->update(['status' => 'confirmed']);
            session()->flash('success', 'تم تأكيد الموعد بنجاح');
        } else {
            session()->flash('error', 'لا يمكن تأكيد هذا الموعد');
        }
    }

    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'completed']);
        session()->flash('success', 'تم إكمال الموعد بنجاح');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $appointment->update(['status' => 'cancelled']);
            session()->flash('success', 'تم إلغاء الموعد بنجاح');
        } else {
            session()->flash('error', 'لا يمكن إلغاء هذا الموعد');
        }
    }

    public function markNoShow($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'no_show']);
        session()->flash('success', 'تم تحديد الموعد كلم يحضر');
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterDate = '';
        $this->filterDoctor = '';
        $this->filterPatient = '';
        $this->dateRangeStart = '';
        $this->dateRangeEnd = '';
        $this->resetPage();
    }

    // Toggle select all
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedAppointments = Appointment::pluck('id')->toArray();
        } else {
            $this->selectedAppointments = [];
        }
    }

    // View toggle
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // Get upcoming appointments for dashboard
    public function getUpcomingAppointments($limit = 5)
    {
        return Appointment::with(['patient', 'doctor'])
            ->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('date')
            ->orderBy('time')
            ->limit($limit)
            ->get();
    }

    // Check if appointment can be confirmed
    public function canConfirm($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    // Check if appointment can be completed
    public function canComplete($status)
    {
        return in_array($status, ['confirmed']);
    }

    // Check if appointment can be cancelled
    public function canCancel($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    // Check if appointment can be edited
    public function canEdit($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    // Check if appointment can be deleted
    public function canDelete($status)
    {
        return ! in_array($status, ['completed']);
    }
}
