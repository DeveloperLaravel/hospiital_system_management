<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_id',
        'type',
        'quantity',
        'user_id',
    ];

    // العلاقة مع الدواء
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
