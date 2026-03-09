<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $name = '';

    public $phone = '';

    public $specialization = '';

    public $license_number = '';

    public $department_id = '';

    public $doctor_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // التحقق من البيانات
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'specialization' => 'required|string|max:255',
        'license_number' => 'nullable|string|max:100',
        'department_id' => 'required|exists:departments,id',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'name.required' => 'اسم الطبيب مطلوب',
        'specialization.required' => 'التخصص مطلوب',
        'department_id.required' => 'اختيار القسم مطلوب',
    ];

    // ============================================
    // Role & Permission Check Methods
    // ============================================

    /**
     * Check if user can view doctors
     */
    public function canView(): bool
    {
        return Auth::user()->can('doctors-view');
    }

    /**
     * Check if user can create doctors
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('doctors-create');
    }

    /**
     * Check if user can edit doctors
     */
    public function canEdit($doctor = null): bool
    {
        if (! $doctor) {
            return Auth::user()->can('doctors-edit');
        }

        return Auth::user()->can('doctors-edit');
    }

    /**
     * Check if user can delete doctors
     */
    public function canDelete($doctor = null): bool
    {
        if (! $doctor) {
            return Auth::user()->can('doctors-delete');
        }

        // Check if doctor has related records
        if ($doctor->appointments()->count() > 0 || $doctor->medicalRecords()->count() > 0) {
            return false;
        }

        return Auth::user()->can('doctors-delete');
    }

    /**
     * Check if user can bulk delete
     */
    public function canBulkDelete(): bool
    {
        return Auth::user()->can('doctors-delete');
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
     * Check if user is receptionist
     */
    public function isReceptionist(): bool
    {
        return Auth::user()->hasRole('Receptionist');
    }

    /**
     * Check if user is nurse
     */
    public function isNurse(): bool
    {
        return Auth::user()->hasRole('Nurse');
    }

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // جلب الأقسام
    public function getDepartmentsProperty()
    {
        return Department::pluck('name', 'id');
    }

    // إحصائيات الأطباء
    public function getStatsProperty()
    {
        return [
            'total' => Doctor::count(),
            'by_department' => Doctor::select('department_id')
                ->selectRaw('count(*) as count')
                ->groupBy('department_id')
                ->get(),
        ];
    }

    // فتح الـ Modal للإضافة
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة طبيب');

            return;
        }

        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    // فتح الـ Modal للتعديل
    public function edit($id)
    {
        if (! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل طبيب');

            return;
        }

        $doctor = Doctor::findOrFail($id);
        $this->doctor_id = $id;
        $this->name = $doctor->name;
        $this->phone = $doctor->phone;
        $this->specialization = $doctor->specialization;
        $this->license_number = $doctor->license_number;
        $this->department_id = $doctor->department_id;
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        // التحقق من الصلاحيات
        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل طبيب');

            return;
        }

        if (! $this->isEditMode && ! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة طبيب');

            return;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'specialization' => $this->specialization,
            'license_number' => $this->license_number,
            'department_id' => $this->department_id,
        ];

        if ($this->isEditMode) {
            Doctor::find($this->doctor_id)->update($data);
            session()->flash('success', 'تم تحديث بيانات الطبيب بنجاح');
        } else {
            Doctor::create($data);
            session()->flash('success', 'تم إضافة الطبيب بنجاح');
        }

        $this->closeModal();
    }

    // حذف الطبيب
    public function delete($id)
    {
        if (! $this->canDelete()) {
            session()->flash('error', 'ليس لديك صلاحية لحذف طبيب');

            return;
        }

        $doctor = Doctor::find($id);

        if ($doctor->appointments()->count() > 0 || $doctor->medicalRecords()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف الطبيب لوجود مواعيد أو سجلات طبية مرتبطة به');

            return;
        }

        $doctor->delete();
        session()->flash('success', 'تم حذف الطبيب بنجاح');
    }

    // إغلاق الـ Modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    // إعادة تعيين الحقول
    private function resetInputFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->specialization = '';
        $this->license_number = '';
        $this->department_id = '';
        $this->doctor_id = null;
        $this->isEditMode = false;
    }

    // عرض الصفحة
    public function render()
    {
        // التحقق من صلاحية العرض
        if (! $this->canView()) {
            return view('livewire.doctor-manager', [
                'doctors' => collect([]),
                'departments' => collect([]),
                'hasPermission' => false,
            ]);
        }

        $doctors = Doctor::with('department')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%')
                    ->orWhere('specialization', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        $departments = $this->departments;

        return view('livewire.doctor-manager', [
            'doctors' => $doctors,
            'departments' => $departments,
            'hasPermission' => true,
        ]);
    }
}
