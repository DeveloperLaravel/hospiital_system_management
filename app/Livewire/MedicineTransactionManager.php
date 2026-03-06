<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Models\MedicineTransaction;
use App\Services\MedicineTransactionService;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class MedicineTransactionManager extends Component
{
    use WithPagination;

    // Component Properties
    public $search = '';

    public $type_filter = '';

    public $medication_filter = '';

    public $date_from = '';

    public $date_to = '';

    // Form Fields
    public $transaction_id = null;

    public $medication_id = '';

    public $type = 'in';

    public $quantity = '';

    public $reference_number = '';

    public $notes = '';

    public $transaction_date = '';

    // Modal States
    public $isOpen = false;

    public $isEditMode = false;

    // Service
    protected MedicineTransactionService $service;

    // Validation Rules
    protected $rules = [
        'medication_id' => 'required|exists:medications,id',
        'type' => 'required|in:in,out',
        'quantity' => 'required|integer|min:1',
        'reference_number' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'transaction_date' => 'nullable|date',
    ];

    // Custom Validation Messages
    protected $messages = [
        'medication_id.required' => 'اختيار الدواء مطلوب',
        'medication_id.exists' => 'الدواء المحدد غير موجود',
        'type.required' => 'نوع المعاملة مطلوب',
        'type.in' => 'نوع المعاملة غير صحيح',
        'quantity.required' => 'الكمية مطلوبة',
        'quantity.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
        'quantity.min' => 'الكمية يجب أن تكون أكبر من صفر',
    ];

    public function boot(MedicineTransactionService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
    }

    // Reset pagination on search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedMedicationFilter()
    {
        $this->resetPage();
    }

    // Open Modal for Create
    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isOpen = true;
        $this->transaction_date = now()->format('Y-m-d');
    }

    // Open Modal for Edit
    public function edit($id)
    {
        $transaction = MedicineTransaction::with('medication')->findOrFail($id);

        $this->transaction_id = $id;
        $this->medication_id = $transaction->medication_id;
        $this->type = $transaction->type;
        $this->quantity = $transaction->quantity;
        $this->reference_number = $transaction->reference_number ?? '';
        $this->notes = $transaction->notes ?? '';
        $this->transaction_date = $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d') : '';

        $this->isEditMode = true;
        $this->isOpen = true;
    }

    // Store (Create or Update)
    public function store()
    {
        $this->validate();

        $data = [
            'medication_id' => $this->medication_id,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'reference_number' => $this->reference_number ?: null,
            'notes' => $this->notes ?: null,
            'transaction_date' => $this->transaction_date ?: null,
            'user_id' => auth()->id(),
        ];

        try {
            if ($this->isEditMode) {
                $transaction = MedicineTransaction::findOrFail($this->transaction_id);

                // Reverse old stock
                $this->reverseStock($transaction);

                // Update
                $transaction->update($data);

                // Apply new stock
                $this->applyStock($transaction);

                session()->flash('success', 'تم تحديث المعاملة بنجاح');
            } else {
                $transaction = MedicineTransaction::create($data);
                $this->applyStock($transaction);
                session()->flash('success', 'تم إضافة المعاملة بنجاح');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: '.$e->getMessage());
        }
    }

    // Delete Transaction
    public function delete($id)
    {
        $transaction = MedicineTransaction::findOrFail($id);

        try {
            // Reverse stock before deletion
            $this->reverseStock($transaction);

            $transaction->delete();
            session()->flash('success', 'تم حذف المعاملة بنجاح');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء الحذف: '.$e->getMessage());
        }
    }

    // Close Modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    // Reset Input Fields
    private function resetInputFields()
    {
        $this->transaction_id = null;
        $this->medication_id = '';
        $this->type = 'in';
        $this->quantity = '';
        $this->reference_number = '';
        $this->notes = '';
        $this->transaction_date = now()->format('Y-m-d');
    }

    // Apply Stock Change
    private function applyStock(MedicineTransaction $transaction): void
    {
        $medication = $transaction->medication;
        if (! $medication) {
            return;
        }

        $currentStock = $medication->quantity ?? 0;

        if ($transaction->type === 'in') {
            $medication->update(['quantity' => $currentStock + $transaction->quantity]);
        } else {
            $newStock = max(0, $currentStock - $transaction->quantity);
            $medication->update(['quantity' => $newStock]);
        }
    }

    // Reverse Stock Change
    private function reverseStock(MedicineTransaction $transaction): void
    {
        $medication = $transaction->medication;
        if (! $medication) {
            return;
        }

        $currentStock = $medication->quantity ?? 0;

        if ($transaction->type === 'in') {
            $newStock = max(0, $currentStock - $transaction->quantity);
            $medication->update(['quantity' => $newStock]);
        } else {
            $medication->update(['quantity' => $currentStock + $transaction->quantity]);
        }
    }

    // Get Medications for Dropdown
    public function getMedicationsProperty(): Collection
    {
        return Medication::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'quantity']);
    }

    // Get Prescriptions for Dropdown
    public function getPrescriptionsProperty(): Collection
    {
        return collect(); // Return empty collection - prescriptions can be linked later if needed
    }

    // Get Filtered Transactions
    public function getTransactionsProperty()
    {
        $query = MedicineTransaction::with(['medication', 'user']);

        // Search filter
        if ($this->search) {
            $query->search($this->search);
        }

        // Type filter
        if ($this->type_filter) {
            $query->where('type', $this->type_filter);
        }

        // Medication filter
        if ($this->medication_filter) {
            $query->byMedication($this->medication_filter);
        }

        // Date range filter
        if ($this->date_from && $this->date_to) {
            $query->whereBetween('created_at', [$this->date_from, $this->date_to]);
        }

        return $query->latestFirst()->paginate(15);
    }

    // Get Statistics
    public function getStatisticsProperty(): array
    {
        $query = MedicineTransaction::query();

        if ($this->medication_filter) {
            $query->where('medication_id', $this->medication_filter);
        }

        if ($this->date_from && $this->date_to) {
            $query->whereBetween('created_at', [$this->date_from, $this->date_to]);
        }

        $totalIn = (clone $query)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $query)->where('type', 'out')->sum('quantity');
        $balance = $totalIn - $totalOut;

        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'balance' => $balance,
            'transaction_count' => (clone $query)->count(),
        ];
    }

    // Clear Filters
    public function clearFilters()
    {
        $this->search = '';
        $this->type_filter = '';
        $this->medication_filter = '';
        $this->date_from = '';
        $this->date_to = '';
        $this->resetPage();
    }

    // Render View
    public function render()
    {
        return view('livewire.medicine-transaction-manager', [
            'transactions' => $this->transactions,
            'medications' => $this->medications,
            'statistics' => $this->statistics,
        ]);
    }
}
