<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Traits\HasRoles;

class AppointmentManager extends Component
{
    use HasRoles, WithFileUploads, WithPagination;

    // ============================================
    // Properties
    // ============================================

    // Search & Filters
    public $search = '';

    public $filterStatus = '';

    public $filterDate = '';

    public $filterDoctor = '';

    public $filterPatient = '';

    public $dateRangeStart = '';

    public $dateRangeEnd = '';

    // Modal States
    public $isOpen = false;

    public $isEditMode = false;

    // Form Fields
    public $appointmentId = null;

    public $patient_id = '';

    public $doctor_id = '';

    public $date = '';

    public $time = '';

    public $status = 'pending';

    public $notes = '';

    public $appointment_type = 'checkup';

    public $is_emergency = false;

    public $duration = 30;

    // Searchable Dropdowns
    public $patientSearch = '';

    public $doctorSearch = '';

    public $showPatientDropdown = false;

    public $showDoctorDropdown = false;

    // Bulk Selection
    public $selectedAppointments = [];

    public $selectAll = false;

    // View Mode
    public $viewMode = 'table';

    // Time Slots
    public $timeSlots = [];

    // ============================================
    // Validation Rules
    // ============================================

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

    // Custom Messages
    protected $messages = [
        'patient_id.required' => 'اختيار المريض مطلوب',
        'doctor_id.required' => 'اختيار الطبيب مطلوب',
        'date.required' => 'التاريخ مطلوب',
        'date.after_or_equal' => 'يجب أن يكون التاريخ اليوم أو بعده',
        'time.required' => 'الوقت مطلوب',
        'status.required' => 'الحالة مطلوبة',
    ];

    // ============================================
    // Status & Type Labels
    // ============================================

    public $statusLabels = [
        'pending' => 'قيد الانتظار',
        'confirmed' => 'مؤكد',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'no_show' => 'لم يحضر',
    ];

    public $appointmentTypes = [
        'checkup' => 'فحص عام',
        'followup' => 'متابعة',
        'emergency' => 'طوارئ',
        'consultation' => 'استشارة',
    ];

    // ============================================
    // Lifecycle Methods
    // ============================================

    public function mount()
    {
        $this->generateTimeSlots();
    }

    /**
     * Livewire lifecycle hook - called when component is being removed
     * This prevents "Method does not exist" errors
     */
    public static function destroying(): void
    {
        // Cleanup when component is removed
    }

    /**
     * Alias for backward compatibility
     */
    public static function deleting(): void
    {
        self::destroying();
    }

    // ============================================
    // Helper Methods
    // ============================================

    public function generateTimeSlots()
    {
        $this->timeSlots = [];
        $startTime = strtotime('08:00');
        $endTime = strtotime('20:00');

        while ($startTime <= $endTime) {
            $this->timeSlots[] = date('H:i', $startTime);
            $startTime += 30 * 60;
        }
    }

    // ============================================
    // Permission Check Methods
    // ============================================

    /**
     * Check if user can view appointments
     */
    public function canView(): bool
    {
        return Auth::user()->can('appointments-view');
    }

    /**
     * Check if user can view all appointments
     */
    public function canViewAll(): bool
    {
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Supervisor')) {
            return true;
        }

        return Auth::user()->can('appointments-view-all');
    }

    /**
     * Check if user can create appointments
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('appointments-create');
    }

    /**
     * Check if user can edit appointments
     */
    public function canEdit($appointment = null): bool
    {
        if (! $appointment) {
            return Auth::user()->can('appointments-edit');
        }

        if (! in_array($appointment->status, ['pending', 'confirmed'])) {
            return false;
        }

        if (Auth::user()->hasRole('Doctor')) {
            $doctor = Auth::user()->doctor;
            if ($doctor && $appointment->doctor_id !== $doctor->id) {
                return false;
            }
        }

        return Auth::user()->can('appointments-edit');
    }

    /**
     * Check if user can delete appointments
     */
    public function canDelete($appointment = null): bool
    {
        if (! $appointment) {
            return Auth::user()->can('appointments-delete');
        }

        if ($appointment->status === 'completed') {
            return false;
        }

        if (Auth::user()->hasRole('Doctor') || Auth::user()->hasRole('Receptionist')) {
            return false;
        }

        return Auth::user()->can('appointments-delete');
    }

    /**
     * Check if user can confirm appointments
     */
    public function canConfirmAppointment($appointment): bool
    {
        if (! in_array($appointment->status, ['pending', 'confirmed'])) {
            return false;
        }

        if (Auth::user()->hasRole('Doctor')) {
            $doctor = Auth::user()->doctor;
            if ($doctor && $appointment->doctor_id !== $doctor->id) {
                return false;
            }
        }

        return Auth::user()->can('appointments-confirm') || Auth::user()->can('appointments-edit');
    }

    /**
     * Check if user can complete appointments
     */
    public function canCompleteAppointment($appointment): bool
    {
        if ($appointment->status !== 'confirmed') {
            return false;
        }

        if (Auth::user()->hasRole('Doctor')) {
            $doctor = Auth::user()->doctor;
            if ($doctor && $appointment->doctor_id !== $doctor->id) {
                return false;
            }
        }

        return Auth::user()->can('appointments-complete') || Auth::user()->can('appointments-edit');
    }

    /**
     * Check if user can cancel appointments
     */
    public function canCancelAppointment($appointment): bool
    {
        if (! in_array($appointment->status, ['pending', 'confirmed'])) {
            return false;
        }

        if (Auth::user()->hasRole('Doctor')) {
            $doctor = Auth::user()->doctor;
            if ($doctor && $appointment->doctor_id !== $doctor->id) {
                return false;
            }
        }

        return Auth::user()->can('appointments-cancel') || Auth::user()->can('appointments-edit');
    }

    /**
     * Check if user can export appointments
     */
    public function canExport(): bool
    {
        return Auth::user()->can('appointments-export');
    }

    /**
     * Check if user can bulk delete
     */
    public function canBulkDelete(): bool
    {
        return Auth::user()->can('appointments-delete') && ! empty($this->selectedAppointments);
    }

    /**
     * Check if user can bulk update status
     */
    public function canBulkUpdateStatus(): bool
    {
        return Auth::user()->can('appointments-edit') && ! empty($this->selectedAppointments);
    }

    // ============================================
    // Role Check Methods
    // ============================================

    public function getUserRole(): string
    {
        return Auth::user()->getRoleNames()->first() ?? 'Guest';
    }

    public function isAdmin(): bool
    {
        return Auth::user()->hasRole('Admin');
    }

    public function isSupervisor(): bool
    {
        return Auth::user()->hasRole('Supervisor');
    }

    public function isDoctor(): bool
    {
        return Auth::user()->hasRole('Doctor');
    }

    public function isReceptionist(): bool
    {
        return Auth::user()->hasRole('Receptionist');
    }

    public function isNurse(): bool
    {
        return Auth::user()->hasRole('Nurse');
    }

    // ============================================
    // User Context Methods
    // ============================================

    public function getCurrentDoctorId(): ?int
    {
        $user = Auth::user();

        if ($user && $user->hasRole('Doctor')) {
            try {
                if ($user->relationLoaded('doctor') && $user->doctor) {
                    return $user->doctor->id;
                }

                $doctor = Doctor::where('name', $user->name)->first();
                if ($doctor) {
                    return $doctor->id;
                }
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    public function isOwnAppointment($appointment): bool
    {
        $doctorId = $this->getCurrentDoctorId();

        return $doctorId && $appointment->doctor_id === $doctorId;
    }

    // ============================================
    // Search & Filter Methods
    // ============================================

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

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedAppointments = Appointment::pluck('id')->toArray();
        } else {
            $this->selectedAppointments = [];
        }
    }

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

    // ============================================
    // Dropdown Selection Methods
    // ============================================

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

    public function getFilteredPatients()
    {
        return Patient::when($this->patientSearch, function ($query) {
            $query->where('name', 'like', '%'.$this->patientSearch.'%');
        })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
    }

    public function getFilteredDoctors()
    {
        return Doctor::when($this->doctorSearch, function ($query) {
            $query->where('name', 'like', '%'.$this->doctorSearch.'%');
        })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
    }

    public function getAvailableTimeSlots()
    {
        if (! $this->doctor_id || ! $this->date) {
            return $this->timeSlots;
        }

        $bookedSlots = Appointment::where('doctor_id', $this->doctor_id)
            ->where('date', $this->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($this->appointmentId, function ($query) {
                $query->where('id', '!=', $this->appointmentId);
            })
            ->pluck('time')
            ->toArray();

        return array_filter($this->timeSlots, function ($slot) use ($bookedSlots) {
            return ! in_array($slot, $bookedSlots);
        });
    }

    // ============================================
    // CRUD Operations
    // ============================================

    /**
     * Open modal for creating new appointment
     */
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء مواعيد');

            return;
        }

        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    /**
     * Open modal for editing appointment
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canEdit($appointment)) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل هذا الموعد');

            return;
        }

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

    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->showPatientDropdown = false;
        $this->showDoctorDropdown = false;
        $this->resetForm();
    }

    /**
     * Reset form fields
     */
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

    /**
     * Store - Create or Update appointment
     */
    public function store()
    {
        // Permission check for create
        if (! $this->canCreate() && ! $this->isEditMode) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء مواعيد');

            return;
        }

        // Permission check for edit
        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل المواعيد');

            return;
        }

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

    /**
     * Delete single appointment
     */
    public function remove($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canDelete($appointment)) {
            session()->flash('error', 'ليس لديك صلاحية لحذف هذا الموعد');

            return;
        }

        $appointment->delete();
        session()->flash('success', 'تم حذف الموعد بنجاح');
    }

    /**
     * Delete single appointment (alias)
     */
    public function delete($id)
    {
        return $this->remove($id);
    }

    /**
     * Delete single appointment (alias for destroy convention)
     */
    public function destroy($id)
    {
        return $this->remove($id);
    }

    /**
     * Bulk delete appointments
     */
    public function bulkDelete()
    {
        if (! $this->canBulkDelete()) {
            session()->flash('error', 'ليس لديك صلاحية للحذف أو يرجى تحديد مواعيد');

            return;
        }

        Appointment::whereIn('id', $this->selectedAppointments)->delete();
        $this->selectedAppointments = [];
        $this->selectAll = false;
        session()->flash('success', 'تم حذف المواعيد المحددة بنجاح');
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus($status)
    {
        if (! $this->canBulkUpdateStatus()) {
            session()->flash('error', 'ليس لديك صلاحية للتحديث أو يرجى تحديد مواعيد');

            return;
        }

        Appointment::whereIn('id', $this->selectedAppointments)->update(['status' => $status]);
        $this->selectedAppointments = [];
        $this->selectAll = false;
        session()->flash('success', 'تم تحديث حالة المواعيد المحددة بنجاح');
    }

    // ============================================
    // Quick Actions
    // ============================================

    /**
     * Confirm appointment
     */
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canConfirmAppointment($appointment)) {
            session()->flash('error', 'لا يمكن تأكيد هذا الموعد');

            return;
        }

        $appointment->update(['status' => 'confirmed']);
        session()->flash('success', 'تم تأكيد الموعد بنجاح');
    }

    /**
     * Complete appointment
     */
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canCompleteAppointment($appointment)) {
            session()->flash('error', 'لا يمكن إكمال هذا الموعد');

            return;
        }

        $appointment->update(['status' => 'completed']);
        session()->flash('success', 'تم إكمال الموعد بنجاح');
    }

    /**
     * Cancel appointment
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canCancelAppointment($appointment)) {
            session()->flash('error', 'لا يمكن إلغاء هذا الموعد');

            return;
        }

        $appointment->update(['status' => 'cancelled']);
        session()->flash('success', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * Mark as no show
     */
    public function markNoShow($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (! $this->canEdit($appointment)) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل هذا الموعد');

            return;
        }

        $appointment->update(['status' => 'no_show']);
        session()->flash('success', 'تم تحديد الموعد كل لم يحضر');
    }

    // ============================================
    // View Methods
    // ============================================

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // ============================================
    // Statistics Methods
    // ============================================

    public function getStatistics($currentDoctorId = null)
    {
        $query = Appointment::query();

        if ($currentDoctorId) {
            $query->where('doctor_id', $currentDoctorId);
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'today' => (clone $query)->whereDate('date', now()->toDateString())->count(),
            'this_week' => (clone $query)->whereBetween('date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])->count(),
            'this_month' => (clone $query)->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
        ];
    }

    public function getCalendarAppointments($currentDoctorId = null)
    {
        $query = Appointment::with(['patient', 'doctor'])
            ->where('date', '>=', now()->toDateString())
            ->where('date', '<=', now()->addDays(30)->toDateString())
            ->whereIn('status', ['pending', 'confirmed']);

        if ($currentDoctorId) {
            $query->where('doctor_id', $currentDoctorId);
        }

        return $query->orderBy('date')
            ->orderBy('time')
            ->get();
    }

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

    // ============================================
    // Status Helper Methods
    // ============================================

    public function canConfirm($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    public function canComplete($status)
    {
        return in_array($status, ['confirmed']);
    }

    public function canCancel($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    public function canEditStatus($status)
    {
        return in_array($status, ['pending', 'confirmed']);
    }

    public function canDeleteStatus($status)
    {
        return ! in_array($status, ['completed']);
    }

    // ============================================
    // Render Method
    // ============================================

    public function render()
    {
        // Check if user has view permission
        if (! $this->canView()) {
            return view('livewire.appointment-manager', [
                'appointments' => collect([]),
                'patients' => collect([]),
                'doctors' => collect([]),
                'stats' => [],
                'calendarAppointments' => collect([]),
                'filteredPatients' => collect([]),
                'filteredDoctors' => collect([]),
                'availableTimeSlots' => [],
                'hasPermission' => false,
            ]);
        }

        // Get current doctor ID if user is a doctor
        $currentDoctorId = $this->getCurrentDoctorId();

        $appointments = Appointment::with(['patient', 'doctor'])
            // Role-based filtering: Doctors only see their own appointments
            ->when($currentDoctorId, function ($query) use ($currentDoctorId) {
                $query->where('doctor_id', $currentDoctorId);
            })
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
            ->when($this->filterDoctor, function ($query) use ($currentDoctorId) {
                // Doctors cannot filter by other doctors
                if ($currentDoctorId) {
                    $query->where('doctor_id', $currentDoctorId);
                } else {
                    $query->where('doctor_id', $this->filterDoctor);
                }
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
            ->orderBy('id', 'desc')
            ->paginate(15);

        // Get patients and doctors for dropdowns
        $patients = Patient::orderBy('name', 'asc')->get();

        // Doctors can only select themselves when creating appointments
        $doctors = $currentDoctorId
            ? Doctor::where('id', $currentDoctorId)->get()
            : Doctor::orderBy('name', 'asc')->get();

        // Statistics - filtered by role
        $stats = $this->getStatistics($currentDoctorId);

        // Calendar data - filtered by role
        $calendarAppointments = $this->getCalendarAppointments($currentDoctorId);

        return view('livewire.appointment-manager', [
            'appointments' => $appointments,
            'patients' => $patients,
            'doctors' => $doctors,
            'stats' => $stats,
            'calendarAppointments' => $calendarAppointments,
            'filteredPatients' => $this->getFilteredPatients(),
            'filteredDoctors' => $this->getFilteredDoctors(),
            'availableTimeSlots' => $this->getAvailableTimeSlots(),
            'hasPermission' => true,
        ]);
    }
}
