<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'national_id',
        'age',
        'gender',
        'phone',
        'blood_type',
        'address',
    ];

    // علاقة المرضى بالمواعيد
    // public function appointments()
    // {
    //     return $this->hasMany(Appointment::class);
    // }

    // علاقة المرضى بالسجلات الطبية
    // public function medicalRecords()
    // {
    //     return $this->hasMany(MedicalRecord::class);
    // }

    // // علاقة المرضى بالفواتير
    // public function invoices()
    // {
    //     return $this->hasMany(Invoice::class);
    // }

}
