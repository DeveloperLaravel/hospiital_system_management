<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $user_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // حقول النموذج
    public $name = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    public $status = 1;

    public $selectedRoles = [];

    public $selectedPermissions = [];

    // الخدمات
    protected UserService $userService;

    // التحقق من البيانات
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'status' => 'required|boolean',
        'selectedRoles' => 'required|array',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'name.required' => 'الاسم مطلوب',
        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email' => 'البريد الإلكتروني غير صالح',
        'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
        'status.required' => 'حالة المستخدم مطلوبة',
        'selectedRoles.required' => 'يجب اختيار دور واحد على الأقل',
    ];

    public function __construct()
    {
        $this->userService = new UserService;
    }

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // جلب الأدوار
    public function getRolesProperty()
    {
        return Role::all();
    }

    // جلب الصلاحيات
    public function getPermissionsProperty()
    {
        return Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);

            return $parts[0] ?? 'other';
        });
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
        $user = User::with(['roles', 'permissions'])->findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = $user->status;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->selectedPermissions = $user->permissions->pluck('id')->toArray();
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        // تحديث قواعد التحقق في وضع التعديل
        if ($this->isEditMode) {
            $this->rules['email'] = 'required|email|unique:users,email,'.$this->user_id;
            $this->rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'roles' => $this->selectedRoles,
            'permissions' => $this->selectedPermissions,
        ];

        // إضافة كلمة المرور فقط إذا تم إدخالها
        if (! empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        try {
            if ($this->isEditMode) {
                $user = User::findOrFail($this->user_id);
                $this->userService->updateUser($data, $user);
                session()->flash('success', 'تم تحديث المستخدم بنجاح');
            } else {
                $data['password'] = Hash::make($this->password);
                $this->userService->createUser($data);
                session()->flash('success', 'تم إنشاء المستخدم بنجاح');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: '.$e->getMessage());
        }
    }

    // حذف المستخدم
    public function delete($id)
    {
        $user = User::find($id);

        if (! $user) {
            session()->flash('error', 'المستخدم غير موجود');

            return;
        }

        // التحقق من المستخدم الأساسي
        if ($user->id == 1) {
            session()->flash('error', 'لا يمكن حذف المستخدم الأساسي');

            return;
        }

        // التحقق من المستخدم الحالي
        if (auth()->id() == $user->id) {
            session()->flash('error', 'لا يمكنك حذف حسابك الحالي');

            return;
        }

        try {
            $this->userService->deleteUser($user);
            session()->flash('success', 'تم حذف المستخدم بنجاح');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // تفعيل/إلغاء تفعيل المستخدم
    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (! $user) {
            session()->flash('error', 'المستخدم غير موجود');

            return;
        }

        if ($user->id == 1) {
            session()->flash('error', 'لا يمكن تعديل حالة المستخدم الأساسي');

            return;
        }

        $user->update(['status' => ! $user->status]);
        session()->flash('success', 'تم تحديث حالة المستخدم بنجاح');
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
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = 1;
        $this->selectedRoles = [];
        $this->selectedPermissions = [];
        $this->user_id = null;
        $this->isEditMode = false;
    }

    // إحصائيات المستخدمين
    public function getStatsProperty()
    {
        return [
            'total' => User::count(),
            'active' => User::where('status', 1)->count(),
            'inactive' => User::where('status', 0)->count(),
            'roles' => Role::count(),
        ];
    }

    // عرض الصفحة
    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        $roles = $this->roles;
        $permissions = $this->permissions;
        $stats = $this->stats;

        return view('livewire.user-manager', [
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
            'stats' => $stats,
        ]);
    }
}
