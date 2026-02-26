<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',
        'status',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    // العلاقة مع المرضى عبر pivot
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_rooms', 'room_id', 'patient_id')
            ->using(RoomPatient::class)
            ->withPivot(['admitted_at', 'discharged_at'])
            ->withTimestamps();
    }

    // المريض الحالي في الغرفة
    public function currentPatient()
    {
        return $this->patients()->wherePivotNull('discharged_at')->first();
    }
}
