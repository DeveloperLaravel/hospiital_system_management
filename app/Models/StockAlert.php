<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_id',
        'current_stock',
        'min_stock',
        'status',
        'alert_date',
        'notes',
    ];

    protected $casts = [
        'alert_date' => 'datetime',
        'current_stock' => 'integer',
        'min_stock' => 'integer',
    ];

    // العلاقة مع الدواء
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    // Scope للبحث
    public function scopeSearch(Builder $query, $value)
    {
        $query->whereHas('medication', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
        });
    }

    // Scope للتصفية حسب الحالة
    public function scopeStatus(Builder $query, $status)
    {
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
    }

    // Scope للتنبيهات النشطة
    public function scopeActive(Builder $query)
    {
        $query->whereIn('status', ['low', 'out']);
    }

    // الحصول على لون الحالة
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'low' => 'yellow',
            'out' => 'red',
            'resolved' => 'green',
            default => 'gray',
        };
    }

    // الحصول على نص الحالة
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'low' => 'منخفض',
            'out' => 'نفد',
            'resolved' => 'تم الحل',
            default => 'غير معروف',
        };
    }

    // هل يحتاج لإعادةestock
    public function getNeedsRestockAttribute()
    {
        return in_array($this->status, ['low', 'out']);
    }
}
