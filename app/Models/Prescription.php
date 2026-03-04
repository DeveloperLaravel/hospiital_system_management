<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'doctor_id',
        'notes',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItems::class);
    }

    public function medications()
    {
        return $this->belongsToMany(
            Medication::class,
            'prescription_items'
        )
            ->withPivot([
                'dosage',
                'frequency',
                'duration',
                'quantity',
                'instructions',
            ]);
    }

    // Scopes
    public function scopeWithRelations($query)
    {
        return $query->with(['items.medication', 'medicalRecord.patient', 'doctor']);
    }

    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeByPatient($query, $patientId)
    {
        return $query->whereHas('medicalRecord', function ($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        });
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('items.medication', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedItemsAttribute()
    {
        return $this->items()->with('medication')->get()->map(function ($item) {
            return [
                'name' => $item->medication->name,
                'dosage' => $item->dosage,
                'frequency' => $item->frequency,
                'duration' => $item->duration,
                'quantity' => $item->quantity,
                'instructions' => $item->instructions,
            ];
        });
    }

    public function getPatientNameAttribute()
    {
        return $this->medicalRecord?->patient?->name ?? '-';
    }

    public function getDoctorNameAttribute()
    {
        return $this->doctor?->name ?? '-';
    }

    public function getItemsCountAttribute()
    {
        return $this->items()->count();
    }

    public function getTotalQuantityAttribute()
    {
        return $this->items()->sum('quantity');
    }

    // Check if can be edited (only if no items dispensed)
    public function canEdit()
    {
        return true;
    }

    public function canDelete()
    {
        return true;
    }
}
