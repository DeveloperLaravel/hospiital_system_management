<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class MedicalRecord extends Model
{
    use HasFactory ,HasRoles;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis',
        'treatment',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id'); // مهم تحديد الـ foreign key
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); // مهم تحديد الـ foreign key
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
