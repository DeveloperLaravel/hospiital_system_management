<?php

namespace App\Livewire;

use App\Models\Department;
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
        $department = Department::findOrFail($id);
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
    public function delete($id)
    {
        $department = Department::find($id);

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
        $departments = Department::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%');
        })
            ->latest()
            ->paginate(10);

        return view('livewire.department-manager', [
            'departments' => $departments,
        ]);
    }
}
