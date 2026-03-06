<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use App\Services\PrescriptionItemService;
use Livewire\Component;
use Livewire\WithPagination;

class PrescriptionItemManager extends Component
{
    use WithPagination;

    // Service instance
    protected $prescriptionItemService;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $prescriptionItemId = null;

    // Filters
    public $filterPrescription = '';

    public $filterMedication = '';

    public $filterDate = '';

    // Form fields
    public $prescription_id = '';

    public $medication_id = '';

    public $dosage = '';

    public $frequency = '';

    public $duration = '';

    public $quantity = '';

    public $instructions = '';

    // Validation rules
    protected $rules = [
        'prescription_id' => 'required|exists:prescriptions,id',
        'medication_id' => 'required|exists:medications,id',
        'dosage' => 'required|string|max:100',
        'frequency' => 'required|string|max:100',
        'duration' => 'required|string|max:100',
        'quantity' => 'required|integer|min:1',
        'instructions' => 'nullable|string|max:500',
    ];

    public function __construct()
    {
        $this->prescriptionItemService = new PrescriptionItemService;
    }

    // Render the view
    public function render()
    {
        $items = $this->prescriptionItemService->getAll([
            'search' => $this->search,
            'prescription_id' => $this->filterPrescription,
            'medication_id' => $this->filterMedication,
            'per_page' => 15,
        ]);

        // Get prescriptions and medications for dropdowns
        $prescriptions = $this->prescriptionItemService->getAvailablePrescriptions();
        $medications = $this->prescriptionItemService->getAvailableMedications();

        // Statistics
        $stats = [
            'total' => PrescriptionItems::count(),
            'today' => PrescriptionItems::whereDate('created_at', today())->count(),
            'this_week' => PrescriptionItems::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
            'this_month' => PrescriptionItems::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('livewire.prescription-item-manager', [
            'items' => $items,
            'prescriptions' => $prescriptions,
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
        $item = $this->prescriptionItemService->getById($id);

        if ($item) {
            $this->prescriptionItemId = $item->id;
            $this->prescription_id = $item->prescription_id;
            $this->medication_id = $item->medication_id;
            $this->dosage = $item->dosage;
            $this->frequency = $item->frequency;
            $this->duration = $item->duration;
            $this->quantity = $item->quantity;
            $this->instructions = $item->instructions ?? '';

            $this->isOpen = true;
            $this->isEditMode = true;
        }
    }

    // Close modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    // Reset form fields
    public function resetForm()
    {
        $this->prescriptionItemId = null;
        $this->prescription_id = '';
        $this->medication_id = '';
        $this->dosage = '';
        $this->frequency = '';
        $this->duration = '';
        $this->quantity = '';
        $this->instructions = '';
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        $data = [
            'prescription_id' => $this->prescription_id,
            'medication_id' => $this->medication_id,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency,
            'duration' => $this->duration,
            'quantity' => $this->quantity,
            'instructions' => $this->instructions ?: null,
        ];

        if ($this->isEditMode && $this->prescriptionItemId) {
            $item = PrescriptionItems::findOrFail($this->prescriptionItemId);
            $this->prescriptionItemService->update($item, $data);
            session()->flash('success', 'تم تحديث عنصر الوصفة بنجاح');
        } else {
            $this->prescriptionItemService->create($data);
            session()->flash('success', 'تمت إضافة عنصر الوصفة بنجاح');
        }

        $this->closeModal();
    }

    // Delete prescription item
    public function delete($id)
    {
        $item = PrescriptionItems::findOrFail($id);
        $this->prescriptionItemService->delete($item);
        session()->flash('success', 'تم حذف عنصر الوصفة بنجاح');
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->filterPrescription = '';
        $this->filterMedication = '';
        $this->filterDate = '';
        $this->resetPage();
    }

    // Get prescription info
    public function getPrescriptionInfo($prescriptionId)
    {
        $prescription = Prescription::with(['medicalRecord.patient', 'doctor'])->find($prescriptionId);

        if (! $prescription) {
            return [
                'patient' => '-',
                'doctor' => '-',
            ];
        }

        return [
            'patient' => $prescription->medicalRecord?->patient?->name ?? '-',
            'doctor' => $prescription->doctor?->name ?? '-',
        ];
    }

    // Get medication info
    public function getMedicationInfo($medicationId)
    {
        $medication = Medication::find($medicationId);

        if (! $medication) {
            return [
                'name' => '-',
                'type' => '-',
            ];
        }

        return [
            'name' => $medication->name,
            'type' => $medication->type ?? '-',
        ];
    }
}
