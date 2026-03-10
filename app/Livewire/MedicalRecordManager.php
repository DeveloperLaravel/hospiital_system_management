<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MedicalRecordManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $recordId = null;

    public $viewMode = 'table'; // table, timeline

    // حقول النموذج
    public $patient_id = '';

    public $doctor_id = '';

    public $appointment_id = '';

    public $visit_date = '';

    public $diagnosis = '';

    public $treatment = '';

    public $symptoms = '';

    public $vital_signs = '';

    public $notes = '';

    // الفلاتر
    public $filterPatient = '';

    public $filterDoctor = '';

    public $filterDateFrom = '';

    public $filterDateTo = '';

    // قواعد التحقق
    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_id' => 'nullable|exists:appointments,id',
        'visit_date' => 'required|date',
        'diagnosis' => 'required|string',
        'treatment' => 'nullable|string',
        'symptoms' => 'nullable|string',
        'vital_signs' => 'nullable|string|max:500',
        'notes' => 'nullable|string',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'patient_id.required' => 'اختيار المريض مطلوب',
        'patient_id.exists' => 'المريض المحدد غير موجود',
        'doctor_id.required' => 'اختيار الطبيب مطلوب',
        'doctor_id.exists' => 'الطبيب المحدد غير موجود',
        'visit_date.required' => 'تاريخ الزيارة مطلوب',
        'visit_date.date' => 'التاريخ غير صحيح',
        'diagnosis.required' => 'التشخيص مطلوب',
        'vital_signs.max' => 'العلامات الحيوية لا يجب أن تتجاوز 500 حرف',
    ];

    // ============================================
    // Role & Permission Check Methods
    // ============================================

    /**
     * Check if user can view medical records
     */
    public function canView(): bool
    {
        return Auth::user()->can('medical-records-view');
    }

    /**
     * Check if user can create medical records
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('medical-records-create');
    }

    /**
     * Check if user can edit medical records
     */
    public function canEdit($record = null): bool
    {
        return Auth::user()->can('medical-records-edit');
    }

    /**
     * Check if user can delete medical records
     */
    public function canDelete($record = null): bool
    {
        if (! $record) {
            return Auth::user()->can('medical-records-delete');
        }

        // Check if record has related prescriptions
        if ($record->prescriptions()->count() > 0) {
            return false;
        }

        return Auth::user()->can('medical-records-delete');
    }

    /**
     * Get user's role name
     */
    public function getUserRole(): string
    {
        return Auth::user()->getRoleNames()->first() ?? 'Guest';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return Auth::user()->hasRole('Admin');
    }

    /**
     * Check if user is supervisor
     */
    public function isSupervisor(): bool
    {
        return Auth::user()->hasRole('Supervisor');
    }

    /**
     * Check if user is doctor
     */
    public function isDoctor(): bool
    {
        return Auth::user()->hasRole('Doctor');
    }

    /**
     * Check if user is nurse
     */
    public function isNurse(): bool
    {
        return Auth::user()->hasRole('Nurse');
    }

    // البحث في الوقت الفعلي
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterPatient()
    {
        $this->resetPage();
    }

    public function updatedFilterDoctor()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateTo()
    {
        $this->resetPage();
    }

    // خصائص محسوبة للأطباء والمرضى
    public function getPatientsProperty()
    {
        return Patient::orderBy('name', 'asc')->get();
    }

    public function getDoctorsProperty()
    {
        return Doctor::orderBy('name', 'asc')->get();
    }

    public function getAppointmentsProperty()
    {
        return Appointment::with(['patient', 'doctor'])
            ->whereIn('status', ['completed', 'confirmed'])
            ->orderBy('date', 'desc')
            ->limit(50)
            ->get();
    }

    // الإحصائيات
    public function getStatsProperty()
    {
        return [
            'total' => MedicalRecord::count(),
            'today' => MedicalRecord::whereDate('visit_date', today())->count(),
            'this_week' => MedicalRecord::whereBetween('visit_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => MedicalRecord::whereMonth('visit_date', now()->month)->count(),
        ];
    }

    // عرض الصفحة
    public function render()
    {
        // التحقق من صلاحية العرض
        if (! $this->canView()) {
            return view('livewire.medical-record-manager', [
                'records' => collect([]),
                'stats' => [],
                'patients' => collect([]),
                'doctors' => collect([]),
                'appointments' => collect([]),
                'hasPermission' => false,
            ]);
        }

        $records = MedicalRecord::with(['patient', 'doctor'])
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->filterPatient, function ($query) {
                $query->where('patient_id', $this->filterPatient);
            })
            ->when($this->filterDoctor, function ($query) {
                $query->where('doctor_id', $this->filterDoctor);
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('visit_date', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateTo, function ($query) {
                $query->whereDate('visit_date', '<=', $this->filterDateTo);
            })
            ->latestFirst()
            ->paginate(12);

        return view('livewire.medical-record-manager', [
            'records' => $records,
            'patients' => $this->patients,
            'doctors' => $this->doctors,
            'appointments' => $this->appointments,
            'stats' => $this->stats,
            'hasPermission' => true,
        ]);
    }

    // فتح نافذة الإضافة
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة سجل طبي');

            return;
        }

        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
        $this->visit_date = now()->format('Y-m-d');
    }

    // فتح نافذة التعديل
    public function edit($id)
    {
        if (! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل سجل طبي');

            return;
        }

        $record = MedicalRecord::findOrFail($id);

        $this->recordId = $record->id;
        $this->patient_id = $record->patient_id;
        $this->doctor_id = $record->doctor_id;
        $this->appointment_id = $record->appointment_id ?? '';
        $this->visit_date = $record->visit_date->format('Y-m-d');
        $this->diagnosis = $record->diagnosis;
        $this->treatment = $record->treatment ?? '';
        $this->symptoms = $record->symptoms ?? '';
        $this->vital_signs = $record->vital_signs ?? '';
        $this->notes = $record->notes ?? '';

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    // إغلاق النافذة
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    // إعادة تعيين النموذج
    public function resetForm()
    {
        $this->recordId = null;
        $this->patient_id = '';
        $this->doctor_id = '';
        $this->appointment_id = '';
        $this->visit_date = '';
        $this->diagnosis = '';
        $this->treatment = '';
        $this->symptoms = '';
        $this->vital_signs = '';
        $this->notes = '';
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        // التحقق من الصلاحيات
        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل سجل طبي');

            return;
        }

        if (! $this->isEditMode && ! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة سجل طبي');

            return;
        }

        $this->validate();

        $data = [
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'appointment_id' => $this->appointment_id ?: null,
            'visit_date' => $this->visit_date,
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment ?: null,
            'symptoms' => $this->symptoms ?: null,
            'vital_signs' => $this->vital_signs ?: null,
            'notes' => $this->notes ?: null,
        ];

        if ($this->isEditMode && $this->recordId) {
            $record = MedicalRecord::findOrFail($this->recordId);
            $record->update($data);
            session()->flash('success', 'تم تحديث السجل الطبي بنجاح');
        } else {
            MedicalRecord::create($data);
            session()->flash('success', 'تمت إضافة السجل الطبي بنجاح');
        }

        $this->closeModal();
    }

    // حذف السجل
    public function delete($id)
    {
        if (! $this->canDelete()) {
            session()->flash('error', 'ليس لديك صلاحية لحذف سجل طبي');

            return;
        }

        $record = MedicalRecord::findOrFail($id);

        // التحقق من الوصفات الطبية المرتبطة
        if ($record->prescriptions()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف السجل الطبي لوجود وصفات مرتبطة');

            return;
        }

        $record->delete();
        session()->flash('success', 'تم حذف السجل الطبي بنجاح');
    }

    // تغيير وضع العرض
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // مسح الفلاتر
    public function clearFilters()
    {
        $this->search = '';
        $this->filterPatient = '';
        $this->filterDoctor = '';
        $this->filterDateFrom = '';
        $this->filterDateTo = '';
        $this->resetPage();
    }

    // الحصول على اسم المريض
    public function getPatientName($id)
    {
        return Patient::find($id)?->name ?? '-';
    }

    // الحصول على اسم الطبيب
    public function getDoctorName($id)
    {
        return Doctor::find($id)?->name ?? '-';
    }
}
