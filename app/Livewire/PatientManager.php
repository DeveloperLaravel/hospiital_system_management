<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
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

    // ============================================
    // Role & Permission Check Methods
    // ============================================

    /**
     * Check if user can view patients
     */
    public function canView(): bool
    {
        return Auth::user()->can('patients-view');
    }

    /**
     * Check if user can create patients
     */
    public function canCreate(): bool
    {
        return Auth::user()->can('patients-create');
    }

    /**
     * Check if user can edit patients
     */
    public function canEdit($patient = null): bool
    {
        return Auth::user()->can('patients-edit');
    }

    /**
     * Check if user can delete patients
     */
    public function canDelete($patient = null): bool
    {
        if (! $patient) {
            return Auth::user()->can('patients-delete');
        }

        // Check if patient has related records
        if ($patient->medicalRecords()->count() > 0 ||
            $patient->invoices()->count() > 0 ||
            $patient->appointments()->count() > 0) {
            return false;
        }

        return Auth::user()->can('patients-delete');
    }

    /**
     * Get user's role name
     */
    public function getUserRole(): string
    {
        return Auth::user()->getRoleNames()->first() ?? 'Guest';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return Auth::user()->hasRole('Admin');
    }

    /**
     * Check if user is supervisor
     */
    public function isSupervisor(): bool
    {
        return Auth::user()->hasRole('Supervisor');
    }

    /**
     * Check if user is doctor
     */
    public function isDoctor(): bool
    {
        return Auth::user()->hasRole('Doctor');
    }

    /**
     * Check if user is receptionist
     */
    public function isReceptionist(): bool
    {
        return Auth::user()->hasRole('Receptionist');
    }

    /**
     * Check if user is nurse
     */
    public function isNurse(): bool
    {
        return Auth::user()->hasRole('Nurse');
    }

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
        // التحقق من صلاحية العرض
        if (! $this->canView()) {
            return view('livewire.patient-manager', [
                'patients' => collect([]),
                'stats' => [],
                'bloodTypes' => [],
                'hasPermission' => false,
            ]);
        }

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
            'hasPermission' => true,
        ]);
    }

    // Open modal for creating
    public function create()
    {
        if (! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة مريض');

            return;
        }

        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    // Open modal for editing
    public function edit($id)
    {
        if (! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل مريض');

            return;
        }

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
        // التحقق من الصلاحيات
        if ($this->isEditMode && ! $this->canEdit()) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل مريض');

            return;
        }

        if (! $this->isEditMode && ! $this->canCreate()) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة مريض');

            return;
        }

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
        if (! $this->canDelete()) {
            session()->flash('error', 'ليس لديك صلاحية لحذف مريض');

            return;
        }

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
