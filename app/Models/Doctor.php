<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'phone',
        'specialization',
        'license_number',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // العلاقة مع المواعيد
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // العلاقة مع السجلات الطبية
    // public function medicalRecords()
    // {
    //     return $this->hasMany(MedicalRecord::class);
    // }
}
