<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceManager extends Component
{
    use WithPagination;

    // خصائص المكون
    public $search = '';

    public $status = '';

    public $patient_id = '';

    public $start_date = '';

    public $end_date = '';

    // خصائص الفاتورة
    public $invoice_id = null;

    public $patient_id_form = '';

    public $invoice_date = '';

    public $due_date = '';

    public $status_form = 'unpaid';

    public $notes = '';

    // خصائص عناصر الفاتورة
    public $items = [];

    public $item_service = '';

    public $item_description = '';

    public $item_price = '';

    public $item_quantity = 1;

    public $editing_item_id = null;

    // التحكم في الـ Modal
    public $isOpen = false;

    public $isEditMode = false;

    public $showItemModal = false;

    public $showDetailsModal = false;

    public $selectedInvoice = null;

    // التحقق من البيانات
    protected $rules = [
        'patient_id_form' => 'required|exists:patients,id',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:invoice_date',
        'status_form' => 'required|in:paid,unpaid,partial,cancelled',
        'notes' => 'nullable|string',
    ];

    protected $rulesItem = [
        'item_service' => 'required|string|max:255',
        'item_description' => 'nullable|string',
        'item_price' => 'required|numeric|min:0',
        'item_quantity' => 'required|integer|min:1',
    ];

    // رسائل الخطأ المخصصة
    protected $messages = [
        'patient_id_form.required' => 'اختيار المريض مطلوب',
        'patient_id_form.exists' => 'المريض المحدد غير موجود',
        'invoice_date.required' => 'تاريخ الفاتورة مطلوب',
        'invoice_date.date' => 'التاريخ غير صالح',
        'due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون بعد تاريخ الفاتورة',
        'status_form.required' => 'الحالة مطلوبة',
        'item_service.required' => 'اسم الخدمة مطلوب',
        'item_price.required' => 'السعر مطلوب',
        'item_price.numeric' => 'السعر يجب أن يكون رقماً',
        'item_quantity.required' => 'الكمية مطلوبة',
        'item_quantity.min' => 'الكمية يجب أن تكون على الأقل 1',
    ];

    // تحديث عند تغيير البحث
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedPatientId()
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
        $invoice = Invoice::with('items')->findOrFail($id);
        $this->invoice_id = $id;
        $this->patient_id_form = $invoice->patient_id;
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        $this->due_date = $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '';
        $this->status_form = $invoice->status;
        $this->notes = $invoice->notes;
        $this->items = $invoice->items->toArray();
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // عرض تفاصيل الفاتورة
    public function showDetails($id)
    {
        $this->selectedInvoice = Invoice::with(['patient', 'items'])->findOrFail($id);
        $this->showDetailsModal = true;
    }

    // حفظ البيانات (إضافة أو تعديل)
    public function store()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $data = [
                'patient_id' => $this->patient_id_form,
                'invoice_date' => $this->invoice_date,
                'due_date' => $this->due_date ?: null,
                'status' => $this->status_form,
                'notes' => $this->notes,
            ];

            if ($this->isEditMode) {
                $invoice = Invoice::find($this->invoice_id);
                $invoice->update($data);

                // Update items
                $this->updateInvoiceItems($invoice);

                session()->flash('success', 'تم تحديث الفاتورة بنجاح');
            } else {
                $data['invoice_number'] = Invoice::generateNumber();
                $data['total'] = 0;
                $invoice = Invoice::create($data);

                // Add items
                $this->updateInvoiceItems($invoice);

                session()->flash('success', 'تم إنشاء الفاتورة بنجاح');
            }

            DB::commit();
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'حدث خطأ أثناء الحفظ: '.$e->getMessage());
        }
    }

    // تحديث عناصر الفاتورة
    private function updateInvoiceItems($invoice)
    {
        // حذف العناصر القديمة
        $invoice->items()->delete();

        // إضافة العناصر الجديدة
        foreach ($this->items as $item) {
            if (! empty($item['service']) && ! empty($item['price'])) {
                $invoice->items()->create([
                    'service' => $item['service'],
                    'description' => $item['description'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }
        }

        // إعادة حساب الإجمالي
        $invoice->calculateTotal();
    }

    // إضافة عنصر جديد للفاتورة
    public function addItem()
    {
        $this->validate($this->rulesItem);

        $this->items[] = [
            'id' => null,
            'service' => $this->item_service,
            'description' => $this->item_description,
            'price' => $this->item_price,
            'quantity' => $this->item_quantity,
        ];

        $this->resetItemFields();
        $this->showItemModal = false;
    }

    // تعديل عنصر
    public function editItem($index)
    {
        $item = $this->items[$index];
        $this->editing_item_id = $index;
        $this->item_service = $item['service'];
        $this->item_description = $item['description'] ?? '';
        $this->item_price = $item['price'];
        $this->item_quantity = $item['quantity'];
        $this->showItemModal = true;
    }

    // تحديث العنصر
    public function updateItem()
    {
        $this->validate($this->rulesItem);

        $this->items[$this->editing_item_id] = [
            'id' => $this->items[$this->editing_item_id]['id'],
            'service' => $this->item_service,
            'description' => $this->item_description,
            'price' => $this->item_price,
            'quantity' => $this->item_quantity,
        ];

        $this->resetItemFields();
        $this->showItemModal = false;
    }

    // حذف عنصر
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // إعادة تعيين حقول العنصر
    private function resetItemFields()
    {
        $this->item_service = '';
        $this->item_description = '';
        $this->item_price = '';
        $this->item_quantity = 1;
        $this->editing_item_id = null;
    }

    // حذف الفاتورة
    public function delete($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $invoice->items()->delete();
            $invoice->delete();
            session()->flash('success', 'تم حذف الفاتورة بنجاح');
        } else {
            session()->flash('error', 'الفاتورة غير موجودة');
        }
    }

    // تحديد الفاتورة كمدفوعة
    public function markAsPaid($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            session()->flash('success', 'تم تحديد الفاتورة كمدفوعة');
        }
    }

    // تحديد الفاتورة كغير مدفوعة
    public function markAsUnpaid($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->update([
                'status' => 'unpaid',
                'paid_at' => null,
            ]);
            session()->flash('success', 'تم تحديد الفاتورة كغير مدفوعة');
        }
    }

    // إغلاق الـ Modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    // إغلاق modal التفاصيل
    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedInvoice = null;
    }

    // إغلاق modal العنصر
    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->resetItemFields();
    }

    // إعادة تعيين الحقول
    private function resetInputFields()
    {
        $this->invoice_id = null;
        $this->patient_id_form = '';
        $this->invoice_date = now()->format('Y-m-d');
        $this->due_date = now()->addDays(30)->format('Y-m-d');
        $this->status_form = 'unpaid';
        $this->notes = '';
        $this->items = [];
        $this->resetItemFields();
    }

    // احسب الإجمالي
    public function calculateSubtotal()
    {
        return array_sum(array_map(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }, $this->items));
    }

    // جلب المرضى
    public function getPatientsProperty()
    {
        return Patient::orderBy('name')->get();
    }

    // إحصائيات الفواتير
    public function getStatisticsProperty()
    {
        $query = Invoice::query();

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('invoice_date', [$this->start_date, $this->end_date]);
        }

        $totalInvoices = (clone $query)->count();
        $totalAmount = (clone $query)->sum('total');
        $paidAmount = (clone $query)->where('status', 'paid')->sum('total');
        $unpaidAmount = (clone $query)->where('status', 'unpaid')->sum('total');

        return [
            'total_invoices' => $totalInvoices,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'unpaid_amount' => $unpaidAmount,
        ];
    }

    // عرض الصفحة
    public function render()
    {
        $invoices = Invoice::with('patient')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    })
                        ->orWhere('invoice_number', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->patient_id, function ($query) {
                $query->where('patient_id', $this->patient_id);
            })
            ->when($this->start_date, function ($query) {
                $query->where('invoice_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->where('invoice_date', '<=', $this->end_date);
            })
            ->latest()
            ->paginate(10);

        $patients = $this->patients;
        $statistics = $this->statistics;

        return view('livewire.invoice-manager', [
            'invoices' => $invoices,
            'patients' => $patients,
            'statistics' => $statistics,
        ]);
    }
}
