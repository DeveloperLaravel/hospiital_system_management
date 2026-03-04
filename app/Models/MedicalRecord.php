<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'visit_date',
        'diagnosis',
        'treatment',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    // السجل الطبي يخص مريض واحد
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // السجل الطبي يخص طبيب واحد
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // السجل الطبي قد يكون مرتبط بموعد
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Scopes
    public function scopeByPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('visit_date', $date);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('visit_date', [$startDate, $endDate]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('patient', function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%");
            })
                ->orWhereHas('doctor', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%");
                })
                ->orWhere('diagnosis', 'like', "%{$search}%")
                ->orWhere('treatment', 'like', "%{$search}%");
        });
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('visit_date', 'desc');
    }

    // Accessors
    public function getFormattedVisitDateAttribute()
    {
        return $this->visit_date ? \Carbon\Carbon::parse($this->visit_date)->format('d/m/Y') : '-';
    }

    public function getShortDiagnosisAttribute()
    {
        return Str::limit($this->diagnosis, 100);
    }

    public function getShortTreatmentAttribute()
    {
        return Str::limit($this->treatment, 100);
    }

    // Check if record has prescriptions
    public function hasPrescriptions()
    {
        return $this->prescriptions()->count() > 0;
    }

    // Get prescriptions count
    public function getPrescriptionsCountAttribute()
    {
        return $this->prescriptions()->count();
    }
}
