<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'notes',
    ];

    // علاقة بالمريض
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // علاقة بالطبيب
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // العلاقة مع السجلات الطبية
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeByPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'قيد الانتظار',
            'confirmed' => 'مؤكد',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->date)->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->time)->format('h:i A');
    }

    // Check if appointment can be edited
    public function canEdit()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // Check if appointment can be cancelled
    public function canCancel()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // Check if appointment is upcoming
    public function isUpcoming()
    {
        return $this->date >= now()->toDateString() && in_array($this->status, ['pending', 'confirmed']);
    }
}
