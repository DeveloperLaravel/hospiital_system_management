<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Models\StockAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StockAlertManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $status_filter = 'all';

    public $stock_alert_id = null;

    public $isOpen = false;

    public $isEditMode = false;

    // حقول النموذج
    public $medication_id = '';

    public $current_stock = '';

    public $min_stock = '';

    public $status = 'low';

    public $alert_date = '';

    public $notes = '';

    // التحقق من البيانات
    protected $rules = [
        'medication_id' => 'required|exists:medications,id',
        'current_stock' => 'required|integer|min:0',
        'min_stock' => 'required|integer|min:0',
        'status' => 'required|in:low,out,resolved',
        'alert_date' => 'required|date',
        'notes' => 'nullable|string',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'medication_id.required' => 'اختيار الدواء مطلوب',
        'medication_id.exists' => 'الدواء المحدد غير موجود',
        'current_stock.required' => 'الكمية الحالية مطلوبة',
        'current_stock.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
        'current_stock.min' => 'الكمية لا يمكن أن تكون سالبة',
        'min_stock.required' => 'الحد الأدنى للكمية مطلوب',
        'min_stock.integer' => 'الحد الأدنى يجب أن يكون رقماً صحيحاً',
        'min_stock.min' => 'الحد الأدنى لا يمكن أن يكون سالباً',
        'status.required' => 'حالة التنبيه مطلوبة',
        'status.in' => 'حالة التنبيه غير صالحة',
        'alert_date.required' => 'تاريخ التنبيه مطلوب',
        'alert_date.date' => 'التاريخ غير صالح',
    ];

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // تحديث عند تغيير التصفية
    public function updatedStatusFilter()
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
        $stockAlert = StockAlert::findOrFail($id);
        $this->stock_alert_id = $id;
        $this->medication_id = $stockAlert->medication_id;
        $this->current_stock = $stockAlert->current_stock;
        $this->min_stock = $stockAlert->min_stock;
        $this->status = $stockAlert->status;
        $this->alert_date = $stockAlert->alert_date->format('Y-m-d H:i:s');
        $this->notes = $stockAlert->notes;
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        $this->validate();

        $data = [
            'medication_id' => $this->medication_id,
            'current_stock' => $this->current_stock,
            'min_stock' => $this->min_stock,
            'status' => $this->status,
            'alert_date' => $this->alert_date,
            'notes' => $this->notes,
        ];

        if ($this->isEditMode) {
            StockAlert::find($this->stock_alert_id)->update($data);
            session()->flash('success', 'تم تحديث تنبيه المخزون بنجاح');
        } else {
            StockAlert::create($data);
            session()->flash('success', 'تم إضافة تنبيه المخزون بنجاح');
        }

        $this->closeModal();
    }

    // حذف التنبيه
    public function delete($id)
    {
        StockAlert::find($id)->delete();
        session()->flash('success', 'تم حذف تنبيه المخزون بنجاح');
    }

    // حل التنبيه (تغيير الحالة إلى resolved)
    public function resolve($id)
    {
        $stockAlert = StockAlert::find($id);
        $stockAlert->update(['status' => 'resolved']);
        session()->flash('success', 'تم حل تنبيه المخزون بنجاح');
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
        $this->medication_id = '';
        $this->current_stock = '';
        $this->min_stock = '';
        $this->status = 'low';
        $this->alert_date = '';
        $this->notes = '';
        $this->stock_alert_id = null;
        $this->isEditMode = false;
    }

    // الحصول على قائمة الأدوية
    public function getMedicationsProperty()
    {
        return Medication::orderBy('name')->get();
    }

    // عرض الصفحة
    public function render()
    {
        $stockAlerts = StockAlert::with('medication')
            ->when($this->search, function ($query) {
                $query->whereHas('medication', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status_filter !== 'all', function ($query) {
                $query->where('status', $this->status_filter);
            })
            ->latest()
            ->paginate(10);

        // إحصائيات
        $stats = [
            'total' => StockAlert::count(),
            'low' => StockAlert::where('status', 'low')->count(),
            'out' => StockAlert::where('status', 'out')->count(),
            'resolved' => StockAlert::where('status', 'resolved')->count(),
        ];

        return view('livewire.stock-alert-manager', [
            'stockAlerts' => $stockAlerts,
            'stats' => $stats,
        ]);
    }
}
