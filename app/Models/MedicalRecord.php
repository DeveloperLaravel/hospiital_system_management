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
        return $this->belongsTo(Patient::class, 'patient_id'); // مهم تحديد الـ foreign key
    }

    // السجل الطبي يخص طبيب واحد
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); // مهم تحديد الـ foreign key
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
}
