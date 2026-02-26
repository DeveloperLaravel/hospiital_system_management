<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomPatient extends Pivot
{
    use HasFactory;

    protected $table = 'patient_rooms'; // اسم جدول pivot

    protected $fillable = [
        'room_id',
        'patient_id',
        'admitted_at',
        'discharged_at',
    ];

    protected $dates = [
        'admitted_at',
        'discharged_at',
        'created_at',
        'updated_at',
    ];

    /**
     * العلاقة مع الغرفة
     */
    // العلاقة مع الغرفة
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * العلاقة مع المريض
     */
    // العلاقة مع المريض
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * تحقق هل المريض موجود حالياً في الغرفة
     */
    // هل المريض موجود حالياً في الغرفة؟
    public function getIsActiveAttribute()
    {
        return $this->discharged_at === null;
    }
}
