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
    // public function medicalRecords()
    // {
    //     return $this->hasMany(MedicalRecord::class);
    // }
}
