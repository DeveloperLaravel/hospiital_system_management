<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class RoomManager extends Component
{
    use WithPagination;

    // Properties
    public $search = '';

    public $isOpen = false;

    public $isEditMode = false;

    public $roomId = null;

    public $viewMode = 'grid'; // grid, table

    // Form fields
    public $room_number = '';

    public $type = 'single';

    public $status = 'available';

    public $floor = 1;

    public $beds_count = 1;

    public $price = 0;

    public $notes = '';

    // Admit/Discharge
    public $admitModalOpen = false;

    public $dischargeModalOpen = false;

    public $selectedRoom = null;

    public $selectedPatient = null;

    // Filters
    public $filterStatus = '';

    public $filterType = '';

    // Validation rules
    protected $rules = [
        'room_number' => 'required|string|max:20',
        'type' => 'required|in:single,double,icu,vip,emergency',
        'status' => 'required|in:available,occupied,maintenance,cleaning',
        'floor' => 'required|integer|min:1|max:20',
        'beds_count' => 'required|integer|min:1|max:10',
        'price' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string|max:500',
    ];

    // Room types
    public $roomTypes = [
        'single' => 'غرفة مفردة',
        'double' => 'غرفة مزدوجة',
        'icu' => 'ICU - العناية المركزة',
        'vip' => 'VIP - جناح',
        'emergency' => 'طوارئ',
    ];

    // Room statuses
    public $roomStatuses = [
        'available' => 'متاحة',
        'occupied' => 'مشغولة',
        'maintenance' => 'صيانة',
        'cleaning' => 'تنظيف',
    ];

    // Real-time search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    // Render
    public function render()
    {
        $rooms = Room::with(['patients' => function ($q) {
            $q->wherePivotNull('discharged_at');
        }])
            ->when($this->search, function ($query) {
                $query->where('room_number', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->orderBy('id', 'desc')
            ->paginate(12);

        // Statistics
        $stats = [
            'total' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        // Available patients for admit - get all patients
        $availablePatients = Patient::orderBy('name', 'asc')->get();

        return view('livewire.room-manager', [
            'rooms' => $rooms,
            'stats' => $stats,
            'availablePatients' => $availablePatients,
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
        $room = Room::findOrFail($id);

        $this->roomId = $room->id;
        $this->room_number = $room->room_number;
        $this->type = $room->type;
        $this->status = $room->status;
        $this->floor = $room->floor;
        $this->beds_count = $room->beds_count;
        $this->price = $room->price;
        $this->notes = $room->notes ?? '';

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    // Close modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->admitModalOpen = false;
        $this->dischargeModalOpen = false;
        $this->resetForm();
    }

    // Reset form
    public function resetForm()
    {
        $this->roomId = null;
        $this->room_number = '';
        $this->type = 'single';
        $this->status = 'available';
        $this->floor = 1;
        $this->beds_count = 1;
        $this->price = 0;
        $this->notes = '';
        $this->selectedRoom = null;
        $this->selectedPatient = null;
    }

    // Store (create or update)
    public function store()
    {
        $this->validate();

        $data = [
            'room_number' => $this->room_number,
            'type' => $this->type,
            'status' => $this->status,
            'floor' => $this->floor,
            'beds_count' => $this->beds_count,
            'price' => $this->price,
            'notes' => $this->notes ?: null,
        ];

        if ($this->isEditMode && $this->roomId) {
            $room = Room::findOrFail($this->roomId);
            $room->update($data);
            session()->flash('success', 'تم تحديث الغرفة بنجاح');
        } else {
            Room::create($data);
            session()->flash('success', 'تمت إضافة الغرفة بنجاح');
        }

        $this->closeModal();
    }

    // Delete room
    public function delete($id)
    {
        $room = Room::findOrFail($id);

        if ($room->status === 'occupied') {
            session()->flash('error', 'لا يمكن حذف غرفة مشغولة');

            return;
        }

        $room->delete();
        session()->flash('success', 'تم حذف الغرفة بنجاح');
    }

    // Open admit modal
    public function openAdmitModal($roomId)
    {
        $this->selectedRoom = Room::findOrFail($roomId);
        $this->admitModalOpen = true;
    }

    // Open discharge modal
    public function openDischargeModal($roomId)
    {
        $this->selectedRoom = Room::findOrFail($roomId);
        $this->dischargeModalOpen = true;
    }

    // Admit patient
    public function admitPatient()
    {
        if (! $this->selectedRoom || ! $this->selectedPatient) {
            session()->flash('error', 'يرجى اختيار المريض');

            return;
        }

        if ($this->selectedRoom->status === 'occupied') {
            session()->flash('error', 'الغرفة مشغولة');

            return;
        }

        $this->selectedRoom->patients()->attach($this->selectedPatient, [
            'admitted_at' => now(),
        ]);

        $this->selectedRoom->update(['status' => 'occupied']);

        session()->flash('success', 'تم إدخال المريض بنجاح');
        $this->closeModal();
    }

    // Discharge patient
    public function dischargePatient()
    {
        if (! $this->selectedRoom) {
            return;
        }

        $currentPatient = $this->selectedRoom->patients()
            ->wherePivotNull('discharged_at')
            ->first();

        if (! $currentPatient) {
            session()->flash('error', 'لا يوجد مريض حالي');

            return;
        }

        $this->selectedRoom->patients()->updateExistingPivot($currentPatient->id, [
            'discharged_at' => now(),
        ]);

        $this->selectedRoom->update(['status' => 'available']);

        session()->flash('success', 'تم إخراج المريض بنجاح');
        $this->closeModal();
    }

    // View toggle
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterType = '';
        $this->resetPage();
    }

    // Get status color
    public function getStatusColor($status)
    {
        $colors = [
            'available' => 'green',
            'occupied' => 'red',
            'maintenance' => 'orange',
            'cleaning' => 'blue',
        ];

        return $colors[$status] ?? 'gray';
    }

    // Get type icon
    public function getTypeIcon($type)
    {
        $icons = [
            'single' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            'double' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
            'icu' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            'vip' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
            'emergency' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        ];

        return $icons[$type] ?? $icons['single'];
    }
}
