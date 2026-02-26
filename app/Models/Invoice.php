<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // تحديث total تلقائيًا
    // public function updateTotal()
    // {
    //     $this->update([
    //         'total' => $this->items()->sum('price'),
    //     ]);
    // }
    public function updateTotal()
    {
        $this->total = $this->items()->sum('price');
        $this->save();
    }
}
