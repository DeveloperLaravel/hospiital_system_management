<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'service',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted()
    {
        static::saved(function ($item) {
            $item->invoice->update([
                'total' => $item->invoice->items
                    ->sum(fn ($i) => $i->quantity * $i->price),
            ]);
        });

        static::deleted(function ($item) {
            $item->invoice->update([
                'total' => $item->invoice->items
                    ->sum(fn ($i) => $i->quantity * $i->price),
            ]);
        });
    }
}
