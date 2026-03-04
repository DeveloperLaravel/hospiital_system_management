<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prescription_id',
        'medication_id',
        'dosage',
        'frequency',
        'duration',
        'quantity',
        'instructions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration' => 'integer',
        'quantity' => 'integer',
    ];

    /**
     * Get the prescription that owns the item.
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Get the medication associated with the item.
     */
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    /**
     * Get the patient through prescription.
     */
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Prescription::class,
            'id',
            'id',
            'prescription_id',
            'medical_record_id'
        )->join('medical_records', 'medical_records.patient_id', 'patients.id');
    }

    /**
     * Scope a query to only include items with specific medication.
     */
    public function scopeByMedication($query, $medicationId)
    {
        return $query->where('medication_id', $medicationId);
    }

    /**
     * Scope a query to only include items with specific prescription.
     */
    public function scopeByPrescription($query, $prescriptionId)
    {
        return $query->where('prescription_id', $prescriptionId);
    }

    /**
     * Scope a query to order by latest.
     */
    public function scopeLatestFirst($query)
    {
        return $query->latest();
    }

    /**
     * Scope a query to filter by search term.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('medication', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
                ->orWhereHas('prescription.medicalRecord.patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Get the medication name.
     */
    public function getMedicationNameAttribute(): string
    {
        return $this->medication?->name ?? '-';
    }

    /**
     * Get the patient name.
     */
    public function getPatientNameAttribute(): string
    {
        return $this->prescription?->medicalRecord?->patient?->name ?? '-';
    }

    /**
     * Get the doctor name.
     */
    public function getDoctorNameAttribute(): string
    {
        return $this->prescription?->doctor?->name ?? '-';
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        return $this->duration.' يوم';
    }

    /**
     * Get formatted instructions.
     */
    public function getFormattedInstructionsAttribute(): string
    {
        return $this->instructions ?? 'لا توجد تعليمات';
    }

    /**
     * Get the total days for this prescription item.
     */
    public function getTotalDaysAttribute(): int
    {
        return $this->duration;
    }

    /**
     * Check if item has instructions.
     */
    public function hasInstructions(): bool
    {
        return ! empty($this->instructions);
    }

    /**
     * Check if medication is active.
     */
    public function isMedicationActive(): bool
    {
        return $this->medication?->is_active ?? false;
    }

    /**
     * Get formatted dosage.
     */
    public function getFormattedDosageAttribute(): string
    {
        return $this->dosage;
    }

    /**
     * Get formatted frequency.
     */
    public function getFormattedFrequencyAttribute(): string
    {
        return $this->frequency;
    }
}
