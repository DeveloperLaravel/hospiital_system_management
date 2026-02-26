<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'expiry_date',
        'description',
        'type',
        'qr_code',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2',
    ];

    // Scope للبحث
    public function scopeSearch(Builder $query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('type', 'like', "%{$value}%");
    }

    // هل الكمية منخفضة
    public function getIsLowStockAttribute()
    {
        return $this->quantity <= 5;
    }

    // هل قريب ينتهي
    public function getIsExpiringSoonAttribute()
    {
        return $this->expiry_date &&
               $this->expiry_date->diffInDays(now()) <= 30;
    }

    public function transactions()
    {
        return $this->hasMany(MedicineTransaction::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
