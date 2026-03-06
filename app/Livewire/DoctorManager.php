<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Doctor;
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
        ]);
    }
}
