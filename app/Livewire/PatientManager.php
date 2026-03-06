<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientManager extends Component
{
    use WithPagination;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $patientId = null;

    // Form fields
    public $name = '';

    public $national_id = '';

    public $age = '';

    public $gender = '';

    public $phone = '';

    public $blood_type = '';

    public $address = '';

    public $balance = 0;

    public $total_paid = 0;

    public $credit_limit = 0;

    // Filters
    public $filterGender = '';

    public $filterBloodType = '';

    public $filterBalanceStatus = '';

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'national_id' => 'nullable|string|max:20',
        'age' => 'nullable|integer|min:0|max:150',
        'gender' => 'nullable|in:male,female',
        'phone' => 'nullable|string|max:20',
        'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'address' => 'nullable|string|max:500',
        'balance' => 'nullable|numeric|min:0',
        'total_paid' => 'nullable|numeric|min:0',
        'credit_limit' => 'nullable|numeric|min:0',
    ];

    // Real-time search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterGender()
    {
        $this->resetPage();
    }

    public function updatedFilterBloodType()
    {
        $this->resetPage();
    }

    public function updatedFilterBalanceStatus()
    {
        $this->resetPage();
    }

    // Render the view
    public function render()
    {
        $patients = Patient::when($this->search, function ($query) {
            $query->search($this->search);
        })
            ->when($this->filterGender, function ($query) {
                $query->where('gender', $this->filterGender);
            })
            ->when($this->filterBloodType, function ($query) {
                $query->where('blood_type', $this->filterBloodType);
            })
            ->when($this->filterBalanceStatus === 'with_balance', function ($query) {
                $query->withBalance();
            })
            ->when($this->filterBalanceStatus === 'overdue', function ($query) {
                $query->overdue();
            })
            ->when($this->filterBalanceStatus === 'no_limit', function ($query) {
                $query->noCreditLimit();
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Statistics
        $stats = [
            'total' => Patient::count(),
            'male' => Patient::where('gender', 'male')->count(),
            'female' => Patient::where('gender', 'female')->count(),
            'with_balance' => Patient::withBalance()->count(),
            'total_balance' => Patient::sum('balance'),
            'total_paid' => Patient::sum('total_paid'),
        ];

        $bloodTypes = Patient::getBloodTypes();

        return view('livewire.patient-manager', [
            'patients' => $patients,
            'stats' => $stats,
            'bloodTypes' => $bloodTypes,
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
        $patient = Patient::findOrFail($id);

        $this->patientId = $patient->id;
        $this->name = $patient->name;
        $this->national_id = $patient->national_id ?? '';
        $this->age = $patient->age ?? '';
        $this->gender = $patient->gender ?? '';
        $this->phone = $patient->phone ?? '';
        $this->blood_type = $patient->blood_type ?? '';
        $this->address = $patient->address ?? '';
        $this->balance = $patient->balance ?? 0;
        $this->total_paid = $patient->total_paid ?? 0;
        $this->credit_limit = $patient->credit_limit ?? 0;

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
        $this->patientId = null;
        $this->name = '';
        $this->national_id = '';
        $this->age = '';
        $this->gender = '';
        $this->phone = '';
        $this->blood_type = '';
        $this->address = '';
        $this->balance = 0;
        $this->total_paid = 0;
        $this->credit_limit = 0;
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'national_id' => $this->national_id ?: null,
            'age' => $this->age ?: null,
            'gender' => $this->gender ?: null,
            'phone' => $this->phone ?: null,
            'blood_type' => $this->blood_type ?: null,
            'address' => $this->address ?: null,
            'balance' => $this->balance ?? 0,
            'total_paid' => $this->total_paid ?? 0,
            'credit_limit' => $this->credit_limit ?? 0,
        ];

        if ($this->isEditMode && $this->patientId) {
            $patient = Patient::findOrFail($this->patientId);
            $patient->update($data);
            session()->flash('success', 'تم تحديث بيانات المريض بنجاح');
        } else {
            Patient::create($data);
            session()->flash('success', 'تمت إضافة المريض بنجاح');
        }

        $this->closeModal();
    }

    // Delete patient
    public function delete($id)
    {
        $patient = Patient::findOrFail($id);

        // Check if patient has related records
        if ($patient->medicalRecords()->count() > 0 ||
            $patient->invoices()->count() > 0 ||
            $patient->appointments()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف المريض لوجود سجلات مرتبطة به');

            return;
        }

        $patient->delete();
        session()->flash('success', 'تم حذف المريض بنجاح');
    }

    // Add payment
    public function addPayment($id)
    {
        $patient = Patient::findOrFail($id);

        // Open payment modal logic would be handled in the view
        // This is just a placeholder for the payment functionality
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->filterGender = '';
        $this->filterBloodType = '';
        $this->filterBalanceStatus = '';
        $this->resetPage();
    }
}
