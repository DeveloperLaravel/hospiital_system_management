<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Shift;
use App\Services\ShiftService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Traits\HasRoles;

class ShiftManager extends Component
{
    use HasRoles, WithFileUploads, WithPagination;

    // ============================================
    // Properties
    // ============================================

    // Search & Filters
    public $search = '';

    public $filterStatus = '';

    public $filterDate = '';

    public $filterDepartment = '';

    public $filterShiftType = '';

    public $dateRangeStart = '';

    public $dateRangeEnd = '';

    // Modal States
    public $isOpen = false;

    public $isEditMode = false;

    // Form Fields
    public $shift_id = null;

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

    // Searchable Dropdowns
    public $employeeSearch = '';

    public $showEmployeeDropdown = false;

    // Bulk Selection
    public $selectedShifts = [];

    public $selectAll = false;

    // View Mode
    public $viewMode = 'table';

    // Quick Stats
    public $quickStats = [];

    // ============================================
    // Validation Rules
    // ============================================

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

    // Custom Messages
    protected $messages = [
        'shift_name.required' => 'اسم الوردية مطلوب',
        'start_time.required' => 'وقت البداية مطلوب',
        'end_time.required' => 'وقت النهاية مطلوب',
        'shift_type.required' => 'نوع الوردية مطلوب',
        'assigned_to.required' => 'الموظف المكلف مطلوب',
        'date.required' => 'التاريخ مطلوب',
        'status.required' => 'الحالة مطلوبة',
    ];

    // ============================================
    // Shift Types Labels
    // ============================================

    public $shiftTypeLabels = [
        'morning' => 'صباحي',
        'evening' => 'مسائي',
        'night' => 'ليلي',
        'day_off' => 'إجازة',
        'on_call' => 'حضور طوارئ',
    ];

    public $statusLabels = [
        'scheduled' => 'مجدول',
        'in_progress' => 'قيد التنفيذ',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'absent' => 'غائب',
    ];

    // ============================================
    // Services
    // ============================================

    protected ShiftService $shiftService;

    public function __construct()
    {
        $this->shiftService = new ShiftService;
    }

    // ============================================
    // Lifecycle Methods
    // ============================================

    /**
     * Livewire lifecycle hook - called when component is being removed
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

    /**
     * Check if user can view shifts
     */
    public function canView(): bool
    {
        return Auth::user()->can('shifts-view');
    }

    /**
     * Check if user can view all shifts
     */
    public function canViewAll(): bool
    {
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Supervisor')) {
            return true;
        }

        return Auth::user()->can('shifts-view-all');
    }

    /**
     * Check if user can create shifts
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('shifts-create');
    }

    /**
     * Check if user can edit shifts
     */
    public function canEdit($shift = null): bool
    {
        if (! $shift) {
            return Auth::user()->can('shifts-edit');
        }

        if (! in_array($shift->status, ['scheduled', 'in_progress'])) {
            return false;
        }

        return Auth::user()->can('shifts-edit');
    }

    /**
     * Check if user can delete shifts
     */
    public function canDelete($shift = null): bool
    {
        if (! $shift) {
            return Auth::user()->can('shifts-delete');
        }

        if ($shift->status === 'completed') {
            return false;
        }

        return Auth::user()->can('shifts-delete');
    }

    /**
     * Check if user can update shift status
     */
    public function canUpdateStatus($shift): bool
    {
        if (! in_array($shift->status, ['scheduled', 'in_progress'])) {
            return false;
        }

        return Auth::user()->can('shifts-edit');
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

    public function isNurse(): bool
    {
        return Auth::user()->hasRole('Nurse');
    }

    /**
     * Check if user is receptionist
     */
    public function isReceptionist(): bool
    {
        return Auth::user()->hasRole('Receptionist');
    }

    /**
     * Check if user can export shifts
     */
    public function canExport(): bool
    {
        return Auth::user()->can('shifts-export');
    }

    /**
     * Check if user can bulk delete
     */
    public function canBulkDelete(): bool
    {
        return Auth::user()->can('shifts-delete') && ! empty($this->selectedShifts);
    }

    /**
     * Check if user can bulk update status
     */
    public function canBulkUpdateStatus(): bool
    {
        return Auth::user()->can('shifts-edit') && ! empty($this->selectedShifts);
    }

    // ============================================
    // View Methods
    // ============================================

    /**
     * Set view mode (table/calendar)
     */
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
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

    public function updatedFilterDepartment()
    {
        $this->resetPage();
    }

    public function updatedFilterShiftType()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedShifts = \App\Models\Shift::pluck('id')->toArray();
        } else {
            $this->selectedShifts = [];
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterDate = '';
        $this->filterDepartment = '';
        $this->filterShiftType = '';
        $this->dateRangeStart = '';
        $this->dateRangeEnd = '';
        $this->resetPage();
    }

    // ============================================
    // Bulk Actions
    // ============================================

    /**
     * Bulk delete shifts
     */
    public function bulkDelete()
    {
        if (! $this->canBulkDelete()) {
            session()->flash('error', 'ليس لديك صلاحية للحذف أو يرجى تحديد ورديات');

            return;
        }

        \App\Models\Shift::whereIn('id', $this->selectedShifts)->delete();
        $this->selectedShifts = [];
        $this->selectAll = false;
        session()->flash('success', 'تم حذف الورديات المحددة بنجاح');
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus($status)
    {
        if (! $this->canBulkUpdateStatus()) {
            session()->flash('error', 'ليس لديك صلاحية للتحديث أو يرجى تحديد ورديات');

            return;
        }

        \App\Models\Shift::whereIn('id', $this->selectedShifts)->update(['status' => $status]);
        $this->selectedShifts = [];
        $this->selectAll = false;
        session()->flash('success', 'تم تحديث حالة الورديات المحددة بنجاح');
    }

    // ============================================
    // Employee Methods
    // ============================================

    public function getDoctorsProperty()
    {
        if ($this->department_id) {
            return Doctor::where('department_id', $this->department_id)->get();
        }

        return Doctor::all();
    }

    public function getNursesProperty()
    {
        if ($this->department_id) {
            return Nurse::where('department_id', $this->department_id)->get();
        }

        return Nurse::all();
    }

    public function getDepartmentsProperty()
    {
        return Department::all();
    }

    public function updatedAssignedType()
    {
        $this->assigned_to = '';
    }

    public function updatedDepartmentId()
    {
        $this->assigned_to = '';
    }

    // ============================================
    // CRUD Operations
    // ============================================

    /**
     * Open modal for creating new shift
     */
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء ورديات');

            return;
        }

        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    /**
     * Open modal for editing shift
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);

        if (! $this->canEdit($shift)) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل هذه الوردية');

            return;
        }

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

    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    /**
     * Reset form fields
     */
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

    /**
     * Store - Create or Update shift
     */
    public function store()
    {
        // Permission check for create
        if (! $this->canCreate() && ! $this->isEditMode) {
            session()->flash('error', 'ليس لديك صلاحية لإنشاء ورديات');

            return;
        }

        // Permission check for edit
        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل الورديات');

            return;
        }

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
            // Check for conflict
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

    /**
     * Delete single shift
     */
    public function remove($id)
    {
        $shift = Shift::findOrFail($id);

        if (! $this->canDelete($shift)) {
            session()->flash('error', 'ليس لديك صلاحية لحذف هذه الوردية');

            return;
        }

        $this->shiftService->deleteShift($shift);
        session()->flash('success', 'تم حذف الوردية بنجاح');
    }

    /**
     * Delete single shift (alias)
     */
    public function delete($id)
    {
        return $this->remove($id);
    }

    /**
     * Update shift status
     */
    public function updateStatus($id, $status)
    {
        $shift = Shift::findOrFail($id);

        if (! $this->canUpdateStatus($shift)) {
            session()->flash('error', 'لا يمكن تحديث حالة هذه الوردية');

            return;
        }

        $this->shiftService->updateShiftStatus($shift, $status);
        session()->flash('success', 'تم تحديث حالة الوردية بنجاح');
    }

    // ============================================
    // Statistics Methods
    // ============================================

    public function getStatsProperty()
    {
        return $this->shiftService->getStats();
    }

    // ============================================
    // Render Method
    // ============================================

    public function render()
    {
        // Check if user has view permission
        if (! $this->canView()) {
            return view('livewire.shift-manager', [
                'shifts' => collect([]),
                'departments' => collect([]),
                'stats' => [],
                'hasPermission' => false,
            ]);
        }

        $shifts = \App\Models\Shift::with(['doctor', 'nurse', 'department'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('shift_name', 'like', '%'.$this->search.'%')
                        ->orWhereHas('doctor', function ($q) {
                            $q->where('name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('nurse', function ($q) {
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
            ->when($this->filterDepartment, function ($query) {
                $query->where('department_id', $this->filterDepartment);
            })
            ->when($this->filterShiftType, function ($query) {
                $query->where('shift_type', $this->filterShiftType);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $departments = $this->departments;
        $stats = $this->stats;

        return view('livewire.shift-manager', [
            'shifts' => $shifts,
            'departments' => $departments,
            'stats' => $stats,
            'hasPermission' => true,
        ]);
    }
}
