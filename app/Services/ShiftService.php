<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;

class ShiftService
{
    /**
     * جلب جميع الورديات مع التصفية
     */
    public function getAllShifts(array $filters = [], int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Shift::with(['department', 'doctor', 'nurse']);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (! empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (! empty($filters['shift_type'])) {
            $query->where('shift_type', $filters['shift_type']);
        }

        if (! empty($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }

        if (! empty($filters['assigned_type'])) {
            $query->where('assigned_type', $filters['assigned_type']);
        }

        return $query->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate($perPage);
    }

    /**
     * جلب وردية محددة
     */
    public function getShiftById(int $id): ?Shift
    {
        return Shift::with(['department', 'doctor', 'nurse'])->find($id);
    }

    /**
     * إنشاء وردية جديدة
     */
    public function createShift(array $data): Shift
    {
        return Shift::create([
            'shift_name' => $data['shift_name'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'shift_type' => $data['shift_type'],
            'department_id' => $data['department_id'] ?? null,
            'assigned_to' => $data['assigned_to'] ?? null,
            'assigned_type' => $data['assigned_type'] ?? null,
            'date' => $data['date'],
            'status' => $data['status'] ?? 'scheduled',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * تحديث وردية
     */
    public function updateShift(Shift $shift, array $data): Shift
    {
        $shift->update([
            'shift_name' => $data['shift_name'] ?? $shift->shift_name,
            'start_time' => $data['start_time'] ?? $shift->start_time,
            'end_time' => $data['end_time'] ?? $shift->end_time,
            'shift_type' => $data['shift_type'] ?? $shift->shift_type,
            'department_id' => $data['department_id'] ?? $shift->department_id,
            'assigned_to' => $data['assigned_to'] ?? $shift->assigned_to,
            'assigned_type' => $data['assigned_type'] ?? $shift->assigned_type,
            'date' => $data['date'] ?? $shift->date,
            'status' => $data['status'] ?? $shift->status,
            'notes' => $data['notes'] ?? $shift->notes,
        ]);

        return $shift->fresh(['department', 'doctor', 'nurse']);
    }

    /**
     * حذف وردية
     */
    public function deleteShift(Shift $shift): bool
    {
        return $shift->delete();
    }

    /**
     * تحديث حالة الوردية
     */
    public function updateShiftStatus(Shift $shift, string $status): Shift
    {
        $shift->update(['status' => $status]);

        return $shift;
    }

    /**
     * جلب الورديات لليوم
     */
    public function getTodayShifts(): Collection
    {
        return Shift::with(['department', 'doctor', 'nurse'])
            ->whereDate('date', now()->toDateString())
            ->orderBy('start_time')
            ->get();
    }

    /**
     * جلب الورديات للقسم
     */
    public function getShiftsByDepartment(int $departmentId): Collection
    {
        return Shift::with(['doctor', 'nurse'])
            ->where('department_id', $departmentId)
            ->whereDate('date', now()->toDateString())
            ->orderBy('start_time')
            ->get();
    }

    /**
     * جلب الورديات للموظف
     */
    public function getShiftsByEmployee(int $employeeId, string $employeeType): Collection
    {
        return Shift::with(['department'])
            ->where('assigned_to', $employeeId)
            ->where('assigned_type', $employeeType)
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    }

    /**
     * إنشاء ورديات متعددة لموظف
     */
    public function createBulkShifts(array $data): Collection
    {
        $shifts = collect();

        foreach ($data['dates'] as $date) {
            $shiftData = [
                'shift_name' => $data['shift_name'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'shift_type' => $data['shift_type'],
                'department_id' => $data['department_id'],
                'assigned_to' => $data['assigned_to'],
                'assigned_type' => $data['assigned_type'],
                'date' => $date,
                'status' => 'scheduled',
                'notes' => $data['notes'] ?? null,
            ];

            $shifts->push($this->createShift($shiftData));
        }

        return $shifts;
    }

    /**
     * جلب قائمة الأطباء للاختيار
     */
    public function getDoctorsList(): \Illuminate\Database\Eloquent\Collection
    {
        return Doctor::with('department')->get();
    }

    /**
     * جلب قائمة الممرضين للاختيار
     */
    public function getNursesList(): \Illuminate\Database\Eloquent\Collection
    {
        return Nurse::with('department')->get();
    }

    /**
     * التحقق من تداخل الورديات
     */
    public function hasConflict(int $assignedTo, string $assignedType, string $date, ?int $excludeShiftId = null): bool
    {
        $query = Shift::where('assigned_to', $assignedTo)
            ->where('assigned_type', $assignedType)
            ->whereDate('date', $date);

        if ($excludeShiftId) {
            $query->where('id', '!=', $excludeShiftId);
        }

        return $query->whereIn('status', ['scheduled', 'in_progress'])->exists();
    }

    /**
     * إحصائيات الورديات
     */
    public function getStats(): array
    {
        return [
            'total' => Shift::count(),
            'scheduled' => Shift::where('status', 'scheduled')->count(),
            'in_progress' => Shift::where('status', 'in_progress')->count(),
            'completed' => Shift::where('status', 'completed')->count(),
            'cancelled' => Shift::where('status', 'cancelled')->count(),
            'absent' => Shift::where('status', 'absent')->count(),
            'today' => Shift::whereDate('date', now()->toDateString())->count(),
        ];
    }
}
