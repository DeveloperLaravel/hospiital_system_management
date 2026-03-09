<?php

namespace App\Livewire;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $name = '';

    public $description = '';

    public $salary = '';

    public $department_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // التحقق من البيانات
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'salary' => 'nullable|numeric|min:0',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'name.required' => 'اسم القسم مطلوب',
        'name.max' => 'اسم القسم طويل جداً',
        'salary.numeric' => 'الراتب يجب أن يكون رقماً',
        'salary.min' => 'الراتب يجب أن يكون رقماً موجباً',
    ];

    // ============================================
    // Role & Permission Check Methods
    // ============================================

    /**
     * Check if user can view departments
     */
    public function canView(): bool
    {
        return Auth::user()->can('departments-view');
    }

    /**
     * Check if user can create departments
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('departments-create');
    }

    /**
     * Check if user can edit departments
     */
    public function canEdit($department = null): bool
    {
        if (! $department) {
            return Auth::user()->can('departments-edit');
        }

        return Auth::user()->can('departments-edit');
    }

    /**
     * Check if user can delete departments
     */
    public function canDelete($department = null): bool
    {
        if (! $department) {
            return Auth::user()->can('departments-delete');
        }

        // Cannot delete if has related doctors or nurses
        if ($department->doctors()->count() > 0 || $department->nurses()->count() > 0) {
            return false;
        }

        return Auth::user()->can('departments-delete');
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

    // ============================================

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // فتح الـ Modal للإضافة
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء أقسام');

            return;
        }

        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    // فتح الـ Modal للتعديل
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        if (! $this->canEdit($department)) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل هذا القسم');

            return;
        }

        $this->department_id = $id;
        $this->name = $department->name;
        $this->description = $department->description;
        $this->salary = $department->salary;
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        if (! $this->canCreate() && ! $this->isEditMode) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء أقسام');

            return;
        }

        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل الأقسام');

            return;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'salary' => $this->salary ?: 0,
        ];

        if ($this->isEditMode) {
            Department::find($this->department_id)->update($data);
            session()->flash('success', 'تم تحديث القسم بنجاح');
        } else {
            Department::create($data);
            session()->flash('success', 'تم إضافة القسم بنجاح');
        }

        $this->closeModal();
    }

    // حذف القسم
    public function destroy($id)
    {
        $department = Department::find($id);

        if (! $this->canDelete($department)) {
            session()->flash('error', 'ليس لديك صلاحية لحذف هذا القسم');

            return;
        }

        if ($department->doctors()->count() > 0 || $department->nurses()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف القسم لوجود أطباء أو ممرضين مرتبطين به');

            return;
        }

        $department->delete();
        session()->flash('success', 'تم حذف القسم بنجاح');
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
        $this->description = '';
        $this->salary = '';
        $this->department_id = null;
        $this->isEditMode = false;
    }

    // عرض الصفحة
    public function render()
    {
        // Check if user has view permission
        if (! $this->canView()) {
            return view('livewire.department-manager', [
                'departments' => collect([]),
                'hasPermission' => false,
            ]);
        }

        $departments = Department::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%');
        })
            ->latest()
            ->paginate(10);

        return view('livewire.department-manager', [
            'departments' => $departments,
            'hasPermission' => true,
        ]);
    }
}
