<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use Livewire\Component;
use Livewire\WithPagination;

class PrescriptionManager extends Component
{
    use WithPagination;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $prescriptionId = null;

    public $viewMode = 'table';

    // Form fields
    public $patient_id = '';

    public $doctor_id = '';

    public $notes = '';

    // Items for prescription
    public $items = [];

    public $medicationSearch = '';

    public $showMedicationDropdown = false;

    // Filters
    public $filterPatient = '';

    public $filterDoctor = '';

    public $filterDate = '';

    // Validation rules
    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'notes' => 'nullable|string|max:1000',
        'items' => 'required|array|min:1',
        'items.*.medication_id' => 'required|exists:medications,id',
        'items.*.dosage' => 'required|string|max:100',
        'items.*.frequency' => 'required|string|max:100',
        'items.*.duration' => 'required|string|max:100',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.instructions' => 'nullable|string|max:500',
    ];

    // Render the view
    public function render()
    {
        $prescriptions = Prescription::with(['medicalRecord.patient', 'doctor', 'items.medication'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('medicalRecord.patient', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    })->orWhereHas('doctor', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    });
                });
            })
            ->when($this->filterPatient, function ($query) {
                $query->whereHas('medicalRecord', function ($q) {
                    $q->where('patient_id', $this->filterPatient);
                });
            })
            ->when($this->filterDoctor, function ($query) {
                $query->where('doctor_id', $this->filterDoctor);
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('created_at', $this->filterDate);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        // Get patients and doctors for dropdowns
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();
        $medications = Medication::orderBy('name', 'asc')->get();

        // Statistics
        $stats = [
            'total' => Prescription::count(),
            'today' => Prescription::whereDate('created_at', today())->count(),
            'this_week' => Prescription::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
            'this_month' => Prescription::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('livewire.prescription-manager', [
            'prescriptions' => $prescriptions,
            'patients' => $patients,
            'doctors' => $doctors,
            'medications' => $medications,
            'stats' => $stats,
        ]);
    }

    // Add item row
    public function addItem()
    {
        $this->items[] = [
            'medication_id' => '',
            'dosage' => '',
            'frequency' => '',
            'duration' => '',
            'quantity' => 1,
            'instructions' => '',
        ];
    }

    // Remove item row
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // Open modal for creating
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
        $this->items = [
            [
                'medication_id' => '',
                'dosage' => '',
                'frequency' => '',
                'duration' => '',
                'quantity' => 1,
                'instructions' => '',
            ],
        ];
    }

    // Open modal for editing
    public function edit($id)
    {
        $prescription = Prescription::with(['items'])->findOrFail($id);

        $this->prescriptionId = $prescription->id;
        $this->patient_id = $prescription->medicalRecord->patient_id ?? '';
        $this->doctor_id = $prescription->doctor_id;
        $this->notes = $prescription->notes ?? '';

        // Load items
        $this->items = [];
        foreach ($prescription->items as $item) {
            $this->items[] = [
                'medication_id' => $item->medication_id,
                'dosage' => $item->dosage,
                'frequency' => $item->frequency,
                'duration' => $item->duration,
                'quantity' => $item->quantity,
                'instructions' => $item->instructions ?? '',
            ];
        }

        $this->isOpen = true;
        $this->isEditMode = true;
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
        $this->prescriptionId = null;
        $this->patient_id = '';
        $this->doctor_id = '';
        $this->notes = '';
        $this->items = [];
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        $data = [
            'doctor_id' => $this->doctor_id,
            'notes' => $this->notes ?: null,
        ];

        if ($this->isEditMode && $this->prescriptionId) {
            $prescription = Prescription::findOrFail($this->prescriptionId);

            // Update or create medical record if needed
            if ($prescription->medicalRecord) {
                $prescription->medicalRecord->update(['patient_id' => $this->patient_id]);
            } else {
                $medicalRecord = \App\Models\MedicalRecord::create([
                    'patient_id' => $this->patient_id,
                    'doctor_id' => $this->doctor_id,
                    'visit_date' => now(),
                    'diagnosis' => 'وصفة طبية',
                ]);
                $data['medical_record_id'] = $medicalRecord->id;
            }

            $prescription->update($data);

            // Delete old items and create new ones
            $prescription->items()->delete();
            foreach ($this->items as $item) {
                PrescriptionItems::create([
                    'prescription_id' => $prescription->id,
                    'medication_id' => $item['medication_id'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'quantity' => $item['quantity'],
                    'instructions' => $item['instructions'] ?: null,
                ]);
            }

            session()->flash('success', 'تم تحديث الوصفة بنجاح');
        } else {
            // Create medical record first
            $medicalRecord = \App\Models\MedicalRecord::create([
                'patient_id' => $this->patient_id,
                'doctor_id' => $this->doctor_id,
                'visit_date' => now(),
                'diagnosis' => 'وصفة طبية',
            ]);

            $data['medical_record_id'] = $medicalRecord->id;

            $prescription = Prescription::create($data);

            foreach ($this->items as $item) {
                PrescriptionItems::create([
                    'prescription_id' => $prescription->id,
                    'medication_id' => $item['medication_id'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'quantity' => $item['quantity'],
                    'instructions' => $item['instructions'] ?: null,
                ]);
            }

            session()->flash('success', 'تمت إضافة الوصفة بنجاح');
        }

        $this->closeModal();
    }

    // Delete prescription
    public function delete($id)
    {
        $prescription = Prescription::findOrFail($id);

        // Delete items first
        $prescription->items()->delete();

        // Delete medical record
        if ($prescription->medicalRecord) {
            $prescription->medicalRecord->delete();
        }

        $prescription->delete();
        session()->flash('success', 'تم حذف الوصفة بنجاح');
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->filterPatient = '';
        $this->filterDoctor = '';
        $this->filterDate = '';
        $this->resetPage();
    }

    // View toggle
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // Get patient name helper
    public function getPatientName($id)
    {
        return Patient::find($id)?->name ?? '-';
    }

    // Get doctor name helper
    public function getDoctorName($id)
    {
        return Doctor::find($id)?->name ?? '-';
    }

    // Get medication name helper
    public function getMedicationName($id)
    {
        return Medication::find($id)?->name ?? '-';
    }
}
