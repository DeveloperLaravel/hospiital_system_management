<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Shift;
use App\Services\ShiftService;
use Livewire\Component;
use Livewire\WithPagination;

class ShiftManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $shift_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // حقول النموذج
    public $shift_name = '';

    public $start_time = '';

    public $end_time = '';

    public $shift_type = 'morning';

    public $department_id = '';

    public $assigned_to = '';

    public $assigned_type = 'doctor';

    public $date = '';

    public $status = 'scheduled';

    public $notes = '';

    // فلاتر
    public $filter_status = '';

    public $filter_date = '';

    public $filter_department = '';

    public $filter_shift_type = '';

    // الخدمات
    protected ShiftService $shiftService;

    // التحقق من البيانات
    protected $rules = [
        'shift_name' => 'required|string|max:255',
        'start_time' => 'required',
        'end_time' => 'required',
        'shift_type' => 'required|in:morning,evening,night,day_off,on_call',
        'department_id' => 'nullable',
        'assigned_to' => 'required',
        'assigned_type' => 'required|in:doctor,nurse',
        'date' => 'required|date',
        'status' => 'required|in:scheduled,in_progress,completed,cancelled,absent',
        'notes' => 'nullable|string',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'shift_name.required' => 'اسم الوردية مطلوب',
        'start_time.required' => 'وقت البداية مطلوب',
        'end_time.required' => 'وقت النهاية مطلوب',
        'shift_type.required' => 'نوع الوردية مطلوب',
        'assigned_to.required' => 'الموظف المكلف مطلوب',
        'date.required' => 'التاريخ مطلوب',
        'status.required' => 'الحالة مطلوبة',
    ];

    public function __construct()
    {
        $this->shiftService = new ShiftService;
    }

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // فتح الـ Modal للإضافة
    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    // فتح الـ Modal للتعديل
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $this->shift_id = $id;
        $this->shift_name = $shift->shift_name;
        $this->start_time = $shift->start_time;
        $this->end_time = $shift->end_time;
        $this->shift_type = $shift->shift_type;
        $this->department_id = $shift->department_id;
        $this->assigned_to = $shift->assigned_to;
        $this->assigned_type = $shift->assigned_type === 'App\Models\Doctor' ? 'doctor' : 'nurse';
        $this->date = $shift->date;
        $this->status = $shift->status;
        $this->notes = $shift->notes;
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        $this->validate();

        $assignedType = $this->assigned_type === 'doctor'
            ? 'App\Models\Doctor'
            : 'App\Models\Nurse';

        $data = [
            'shift_name' => $this->shift_name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'shift_type' => $this->shift_type,
            'department_id' => $this->department_id ?: null,
            'assigned_to' => $this->assigned_to,
            'assigned_type' => $assignedType,
            'date' => $this->date,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        try {
            // التحقق من تداخل الورديات
            if (! $this->isEditMode) {
                if ($this->shiftService->hasConflict($this->assigned_to, $assignedType, $this->date)) {
                    session()->flash('error', 'يوجد وردية أخرى في نفس الوقت لهذا الموظف');

                    return;
                }
            } else {
                if ($this->shiftService->hasConflict($this->assigned_to, $assignedType, $this->date, $this->shift_id)) {
                    session()->flash('error', 'يوجد وردية أخرى في نفس الوقت لهذا الموظف');

                    return;
                }
            }

            if ($this->isEditMode) {
                $shift = Shift::find($this->shift_id);
                $this->shiftService->updateShift($shift, $data);
                session()->flash('success', 'تم تحديث الوردية بنجاح');
            } else {
                $this->shiftService->createShift($data);
                session()->flash('success', 'تم إنشاء الوردية بنجاح');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: '.$e->getMessage());
        }
    }

    // حذف الوردية
    public function delete($id)
    {
        try {
            $shift = Shift::findOrFail($id);
            $this->shiftService->deleteShift($shift);
            session()->flash('success', 'تم حذف الوردية بنجاح');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: '.$e->getMessage());
        }
    }

    // تحديث حالة الوردية
    public function updateStatus($id, $status)
    {
        try {
            $shift = Shift::findOrFail($id);
            $this->shiftService->updateShiftStatus($shift, $status);
            session()->flash('success', 'تم تحديث حالة الوردية بنجاح');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: '.$e->getMessage());
        }
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
        $this->shift_name = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->shift_type = 'morning';
        $this->department_id = '';
        $this->assigned_to = '';
        $this->assigned_type = 'doctor';
        $this->date = '';
        $this->status = 'scheduled';
        $this->notes = '';
        $this->shift_id = null;
        $this->isEditMode = false;
    }

    // جلب قائمة الأطباء
    public function getDoctorsProperty()
    {
        if ($this->department_id) {
            return Doctor::where('department_id', $this->department_id)->get();
        }

        return Doctor::all();
    }

    // جلب قائمة الممرضين
    public function getNursesProperty()
    {
        if ($this->department_id) {
            return Nurse::where('department_id', $this->department_id)->get();
        }

        return Nurse::all();
    }

    // جلب الأقسام
    public function getDepartmentsProperty()
    {
        return Department::all();
    }

    // إحصائيات الورديات
    public function getStatsProperty()
    {
        return $this->shiftService->getStats();
    }

    // جلب الموظفين عند تغيير النوع
    public function updatedAssignedType()
    {
        $this->assigned_to = '';
    }

    // جلب الموظفين عند تغيير القسم
    public function updatedDepartmentId()
    {
        $this->assigned_to = '';
    }

    // مسح الفلاتر
    public function clearFilters()
    {
        $this->filter_status = '';
        $this->filter_date = '';
        $this->filter_department = '';
        $this->filter_shift_type = '';
        $this->search = '';
    }

    // عرض الصفحة
    public function render()
    {
        $filters = [
            'status' => $this->filter_status,
            'date' => $this->filter_date,
            'department_id' => $this->filter_department,
            'shift_type' => $this->filter_shift_type,
        ];

        $shifts = $this->shiftService->getAllShifts($filters, 10);
        $departments = $this->departments;
        $stats = $this->stats;

        return view('livewire.shift-manager', [
            'shifts' => $shifts,
            'departments' => $departments,
            'stats' => $stats,
        ]);
    }
}
