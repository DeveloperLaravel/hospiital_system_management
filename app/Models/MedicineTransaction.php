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

    public function medicine()
    {
        return $this->belongsTo(Medication::class);
    }
}
