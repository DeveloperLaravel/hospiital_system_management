<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_name',
        'start_time',
        'end_time',
        'shift_type',
        'department_id',
        'assigned_to',
        'assigned_type',
        'date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'date' => 'date',
    ];

    /**
     * العلاقة بالقسم
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * العلاقة بالمستخدم المكلف (طبيب أو ممرض)
     */
    public function assignedUser()
    {
        return $this->belongsTo($this->assigned_type, 'assigned_to');
    }

    /**
     * العلاقة بالطبيب
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'assigned_to');
    }

    /**
     * العلاقة بالممرض
     */
    public function nurse(): BelongsTo
    {
        return $this->belongsTo(Nurse::class, 'assigned_to');
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by date
     */
    public function scopeDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope to filter by department
     */
    public function scopeDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope to filter by shift type
     */
    public function scopeShiftType($query, $type)
    {
        return $query->where('shift_type', $type);
    }

    /**
     * Get the shift type label in Arabic
     */
    public function getShiftTypeLabelAttribute(): string
    {
        $labels = [
            'morning' => 'صباحي',
            'evening' => 'مسائي',
            'night' => 'ليلي',
            'day_off' => 'إجازة',
            'on_call' => 'حضور طوارئ',
        ];

        return $labels[$this->shift_type] ?? $this->shift_type;
    }

    /**
     * Get the status label in Arabic
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'scheduled' => 'مجدول',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'absent' => 'غائب',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get the status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'scheduled' => 'blue',
            'in_progress' => 'yellow',
            'completed' => 'green',
            'cancelled' => 'red',
            'absent' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Check if shift is active (currently happening)
     */
    public function isActive(): bool
    {
        $now = now();
        $start = $this->start_time;
        $end = $this->end_time;

        // Handle night shifts that span to next day
        if ($this->shift_type === 'night') {
            return $now->format('H:i') >= $start->format('H:i') || $now->format('H:i') <= $end->format('H:i');
        }

        return $now->format('H:i') >= $start->format('H:i') && $now->format('H:i') <= $end->format('H:i');
    }

    /**
     * Get duration in hours
     */
    public function getDurationHoursAttribute(): float
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);

        // Handle night shifts
        if ($end < $start) {
            $end->addDay();
        }

        return $start->diffInMinutes($end) / 60;
    }
}
