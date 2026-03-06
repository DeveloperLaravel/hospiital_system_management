<?php

namespace App\Livewire;

use App\Services\PermissionService;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $permission_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // حقول النموذج
    public $name = '';

    public $guard_name = 'web';

    // الخدمات
    protected $permissionService;

    // التحقق من البيانات
    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'guard_name' => 'required|string|max:255',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'name.required' => 'اسم الصلاحية مطلوب',
        'name.max' => 'اسم الصلاحية طويل جداً',
        'name.unique' => 'اسم الصلاحية موجود مسبقاً',
        'guard_name.required' => 'نوع الصلاحية مطلوب',
    ];

    public function __construct()
    {
        $this->permissionService = new PermissionService;
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
        $permission = Permission::findOrFail($id);
        $this->permission_id = $id;
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        // تحديث قواعد التحقق في وضع التعديل
        if ($this->isEditMode) {
            $this->rules['name'] = 'required|string|max:255|unique:permissions,name,'.$this->permission_id;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ];

        if ($this->isEditMode) {
            $permission = Permission::find($this->permission_id);
            $permission->update($data);
            session()->flash('success', 'تم تحديث الصلاحية بنجاح');
        } else {
            Permission::create($data);
            session()->flash('success', 'تم إنشاء الصلاحية بنجاح');
        }

        $this->closeModal();
    }

    // حذف الصلاحية
    public function delete($id)
    {
        $permission = Permission::find($id);

        if ($permission->roles()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف الصلاحية لوجود أدوار مرتبطة بها');

            return;
        }

        if ($permission->users()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف الصلاحية لوجود مستخدمين مرتبطين بها');

            return;
        }

        $permission->delete();
        session()->flash('success', 'تم حذف الصلاحية بنجاح');
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
        $this->guard_name = 'web';
        $this->permission_id = null;
        $this->isEditMode = false;
    }

    // عرض الصفحة
    public function render()
    {
        $permissions = Permission::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('guard_name', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        // إحصائيات
        $stats = [
            'total' => Permission::count(),
            'web' => Permission::where('guard_name', 'web')->count(),
            'api' => Permission::where('guard_name', 'api')->count(),
        ];

        return view('livewire.permission-manager', [
            'permissions' => $permissions,
            'stats' => $stats,
        ]);
    }
}
