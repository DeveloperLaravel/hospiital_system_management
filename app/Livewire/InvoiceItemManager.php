<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\InvoiceItemService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceItemManager extends Component
{
    use WithPagination;

    // Service instance
    protected InvoiceItemService $invoiceItemService;

    // Search and filter properties
    public $search = '';

    public $invoice_id = '';

    public $status = '';

    // Form properties
    public $item_id = null;

    public $invoice_id_form = '';

    public $service = '';

    public $description = '';

    public $price = '';

    public $quantity = 1;

    // Modal states
    public $isOpen = false;

    public $isEditMode = false;

    public $showDetailsModal = false;

    public $selectedItem = null;

    // Validation rules
    protected $rules = [
        'invoice_id_form' => 'required|exists:invoices,id',
        'service' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
    ];

    // Custom messages
    protected $messages = [
        'invoice_id_form.required' => 'اختيار الفاتورة مطلوب',
        'invoice_id_form.exists' => 'الفاتورة المحددة غير موجودة',
        'service.required' => 'اسم الخدمة مطلوب',
        'service.max' => 'اسم الخدمة طويل جداً',
        'price.required' => 'السعر مطلوب',
        'price.numeric' => 'السعر يجب أن يكون رقماً',
        'price.min' => 'السعر يجب أن يكون أكبر من صفر',
        'quantity.required' => 'الكمية مطلوبة',
        'quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
    ];

    public function __construct()
    {
        $this->invoiceItemService = new InvoiceItemService;
    }

    // Mount - initialize
    public function mount()
    {
        $this->resetInputFields();
    }

    // Updated search - reset pagination
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedInvoiceId()
    {
        $this->resetPage();
    }

    // Open modal for create
    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    // Open modal for edit
    public function edit($id)
    {
        $item = InvoiceItem::with('invoice')->findOrFail($id);

        $this->item_id = $id;
        $this->invoice_id_form = $item->invoice_id;
        $this->service = $item->service;
        $this->description = $item->description ?? '';
        $this->price = $item->price;
        $this->quantity = $item->quantity;

        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // Show details
    public function showDetails($id)
    {
        $this->selectedItem = InvoiceItem::with(['invoice', 'invoice.patient'])->findOrFail($id);
        $this->showDetailsModal = true;
    }

    // Store - create or update
    public function store()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $data = [
                'service' => $this->service,
                'description' => $this->description ?: null,
                'price' => $this->price,
                'quantity' => $this->quantity,
            ];

            $invoice = Invoice::findOrFail($this->invoice_id_form);

            // Prevent editing if invoice is paid
            if ($invoice->status === 'paid') {
                session()->flash('error', 'لا يمكن تعديل عناصر فاتورة مدفوعة');
                DB::rollBack();

                return;
            }

            if ($this->isEditMode) {
                $item = InvoiceItem::findOrFail($this->item_id);
                $item->update($data);
                session()->flash('success', 'تم تحديث العنصر بنجاح');
            } else {
                $invoice->items()->create($data);
                session()->flash('success', 'تم إضافة العنصر بنجاح');
            }

            DB::commit();
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء الحفظ: '.$e->getMessage());
        }
    }

    // Delete item
    public function delete($id)
    {
        try {
            $item = InvoiceItem::findOrFail($id);
            $invoice = $item->invoice;

            // Prevent deleting if invoice is paid
            if ($invoice->status === 'paid') {
                session()->flash('error', 'لا يمكن حذف عناصر من فاتورة مدفوعة');

                return;
            }

            $item->delete();
            session()->flash('success', 'تم حذف العنصر بنجاح');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء الحذف: '.$e->getMessage());
        }
    }

    // Close modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    // Close details modal
    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedItem = null;
    }

    // Reset input fields
    private function resetInputFields()
    {
        $this->item_id = null;
        $this->invoice_id_form = '';
        $this->service = '';
        $this->description = '';
        $this->price = '';
        $this->quantity = 1;
    }

    // Get statistics
    public function getStatisticsProperty()
    {
        $query = InvoiceItem::query();

        if ($this->invoice_id) {
            $query->where('invoice_id', $this->invoice_id);
        }

        $totalItems = (clone $query)->count();
        $totalAmount = (clone $query)->sum(DB::raw('price * quantity'));

        return [
            'total_items' => $totalItems,
            'total_amount' => $totalAmount,
        ];
    }

    // Get invoices for dropdown
    public function getInvoicesProperty()
    {
        return Invoice::with('patient')
            ->orderBy('invoice_date', 'desc')
            ->get();
    }

    // Calculate item total
    public function calculateItemTotal(): float
    {
        return floatval($this->price ?? 0) * intval($this->quantity ?? 1);
    }

    // Render the view
    public function render()
    {
        $items = InvoiceItem::with(['invoice', 'invoice.patient'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('service', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhereHas('invoice', function ($q) {
                            $q->where('invoice_number', 'like', '%'.$this->search.'%')
                                ->orWhereHas('patient', function ($q) {
                                    $q->where('name', 'like', '%'.$this->search.'%');
                                });
                        });
                });
            })
            ->when($this->invoice_id, function ($query) {
                $query->where('invoice_id', $this->invoice_id);
            })
            ->when($this->status, function ($query) {
                $query->whereHas('invoice', function ($q) {
                    $q->where('status', $this->status);
                });
            })
            ->latest()
            ->paginate(10);

        $invoices = $this->invoices;
        $statistics = $this->statistics;

        return view('livewire.invoice-item-manager', [
            'items' => $items,
            'invoices' => $invoices,
            'statistics' => $statistics,
        ]);
    }
}
