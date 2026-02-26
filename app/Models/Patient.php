<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Model
{
    use HasFactory ,HasRoles;

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
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // علاقة المرضى بالسجلات الطبية
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // علاقة المرضى بالفواتير
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'patient_rooms', 'patient_id', 'room_id')
            ->using(RoomPatient::class)
            ->withPivot(['admitted_at', 'discharged_at'])
            ->withTimestamps();
    }

    /**
     * الغرفة الحالية للمريض (إذا كان موجود)
     */
    public function currentRoom()
    {
        return $this->rooms()->wherePivotNull('discharged_at')->first();
    }
}
