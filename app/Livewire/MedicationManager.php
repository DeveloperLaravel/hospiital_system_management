<?php

namespace App\Livewire;

use App\Models\Medication;
use Livewire\Component;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MedicationManager extends Component
{
    use WithPagination;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $medicationId = null;

    // Form fields
    public $name = '';

    public $type = '';

    public $description = '';

    public $quantity = '';

    public $min_stock = '';

    public $price = '';

    public $expiry_date = '';

    public $barcode = '';

    public $is_active = true;

    // QR Code
    public $showQrCode = false;

    public $qrCodeData = '';

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'nullable|string|max:100',
        'description' => 'nullable|string|max:1000',
        'quantity' => 'required|integer|min:0',
        'min_stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'expiry_date' => 'nullable|date',
        'barcode' => 'nullable|string|max:100',
        'is_active' => 'boolean',
    ];

    // Render the view
    public function render()
    {
        $medications = Medication::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('type', 'like', '%'.$this->search.'%')
                    ->orWhere('barcode', 'like', '%'.$this->search.'%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(15);

        // Statistics
        $stats = [
            'total' => Medication::count(),
            'active' => Medication::where('is_active', true)->count(),
            'low_stock' => Medication::whereRaw('quantity <= min_stock')->count(),
            'expiring_soon' => Medication::whereNotNull('expiry_date')
                ->whereDate('expiry_date', '<=', now()->addDays(30))
                ->count(),
        ];

        return view('livewire.medication-manager', [
            'medications' => $medications,
            'stats' => $stats,
        ]);
    }

    // Open modal for creating
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    // Open modal for editing
    public function edit($id)
    {
        $medication = Medication::findOrFail($id);

        $this->medicationId = $medication->id;
        $this->name = $medication->name;
        $this->type = $medication->type ?? '';
        $this->description = $medication->description ?? '';
        $this->quantity = $medication->quantity;
        $this->min_stock = $medication->min_stock;
        $this->price = $medication->price;
        $this->expiry_date = $medication->expiry_date ? $medication->expiry_date->format('Y-m-d') : '';
        $this->barcode = $medication->barcode ?? '';
        $this->is_active = $medication->is_active;

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    // Close modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->showQrCode = false;
        $this->resetForm();
    }

    // Reset form fields
    public function resetForm()
    {
        $this->medicationId = null;
        $this->name = '';
        $this->type = '';
        $this->description = '';
        $this->quantity = '';
        $this->min_stock = '';
        $this->price = '';
        $this->expiry_date = '';
        $this->barcode = '';
        $this->is_active = true;
        $this->qrCodeData = '';
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'type' => $this->type ?: null,
            'description' => $this->description ?: null,
            'quantity' => $this->quantity,
            'min_stock' => $this->min_stock,
            'price' => $this->price,
            'expiry_date' => $this->expiry_date ?: null,
            'barcode' => $this->barcode ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditMode && $this->medicationId) {
            $medication = Medication::findOrFail($this->medicationId);
            $medication->update($data);
            session()->flash('success', 'تم تحديث الدواء بنجاح');
        } else {
            Medication::create($data);
            session()->flash('success', 'تمت إضافة الدواء بنجاح');
        }

        $this->closeModal();
    }

    // Delete medication
    public function delete($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();
        session()->flash('success', 'تم حذف الدواء بنجاح');
    }

    // Toggle status
    public function toggleStatus($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->update(['is_active' => ! $medication->is_active]);
        session()->flash('success', 'تم تغيير حالة الدواء بنجاح');
    }

    // Show QR Code
    public function showQrCode($id)
    {
        $medication = Medication::findOrFail($id);

        // Generate QR code data
        $qrData = json_encode([
            'id' => $medication->id,
            'name' => $medication->name,
            'type' => $medication->type,
            'barcode' => $medication->barcode,
            'price' => $medication->price,
        ]);

        $this->qrCodeData = base64_encode(QrCode::format('svg')->size(200)->generate($qrData));
        $this->showQrCode = true;
    }

    // Clear search
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    // Generate barcode
    public function generateBarcode()
    {
        $this->barcode = 'MED-'.strtoupper(uniqid());
    }
}
