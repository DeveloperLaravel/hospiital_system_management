<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'medical_record_id',
    //     'medication_id',
    //     'dosage',
    //     'duration',
    // ];
    protected $fillable = [
        'medical_record_id',
        'doctor_id',
        'notes',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
    // علاقة العناصر التفصيلية

    public function items()
    {
        return $this->hasMany(PrescriptionItems::class);
    }
    // علاقة الأدوية لتقارير سريعة

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

    // ملاحظة: يمكن عمل دوال مساعدة للحصول على وصفة جاهزة للطباعة
    public function formattedItems()
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
}
