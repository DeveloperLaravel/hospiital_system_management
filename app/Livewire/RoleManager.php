<?php

namespace App\Livewire;

use App\Services\RoleService;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $role_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // حقول النموذج
    public $name = '';

    public $selectedPermissions = [];

    // الخدمات
    protected RoleService $roleService;

    // التحقق من البيانات
    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'name.required' => 'اسم الدور مطلوب',
        'name.max' => 'اسم الدور طويل جداً',
        'name.unique' => 'اسم الدور موجود مسبقاً',
    ];

    public function __construct()
    {
        $this->roleService = new RoleService;
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
        $role = Role::find($id);
        // التحقق من وجود مستخدمين مرتبطين بالدور
        if ($role->users()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف الدور لوجود مستخدمين مرتبطين به');

            return;
        }
        $role = Role::with('permissions')->findOrFail($id);
        $this->role_id = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        // تحديث قواعد التحقق في وضع التعديل
        if ($this->isEditMode) {
            $this->rules['name'] = 'required|string|max:255|unique:roles,name,'.$this->role_id;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'permissions' => $this->selectedPermissions,
        ];

        if ($this->isEditMode) {
            $role = Role::find($this->role_id);
            $this->roleService->updateRole($role, $data);
            session()->flash('success', 'تم تحديث الدور بنجاح');
        } else {
            $this->roleService->createRole($data);
            session()->flash('success', 'تم إنشاء الدور بنجاح');
        }

        $this->closeModal();
    }

    // حذف الدور
    public function delete($id)
    {
        $role = Role::find($id);

        // التحقق من وجود مستخدمين مرتبطين بالدور
        if ($role->users()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف الدور لوجود مستخدمين مرتبطين به');

            return;
        }

        // التحقق من كون الدور هو الدور الافتراضي
        if ($role->name === 'Admin' || $role->name === 'admin') {
            session()->flash('error', 'لا يمكن حذف دور المدير');

            return;
        }

        $this->roleService->deleteRole($role);
        session()->flash('success', 'تم حذف الدور بنجاح');
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
        $this->selectedPermissions = [];
        $this->role_id = null;
        $this->isEditMode = false;
    }

    // الحصول على عدد المستخدمين للدور
    public function getUsersCount($roleId)
    {
        $role = Role::find($roleId);

        return $role ? $role->users()->count() : 0;
    }

    // عرض الصفحة
    public function render()
    {
        $roles = Role::query()
            ->with(['permissions', 'users'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        $permissions = Permission::all()->groupBy(function ($permission) {
            // تجميع الصلاحيات حسب البادئة
            $parts = explode('-', $permission->name);

            return $parts[0] ?? 'other';
        });

        // إحصائيات
        $stats = [
            'total' => Role::count(),
            'withPermissions' => Role::whereHas('permissions')->count(),
            'withoutPermissions' => Role::doesntHave('permissions')->count(),
        ];

        return view('livewire.role-manager', [
            'roles' => $roles,
            'permissions' => $permissions,
            'stats' => $stats,
        ]);
    }
}
