<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'service',
        'description',
        'price',
        'quantity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the invoice that owns the item.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Calculate item total.
     */
    public function getTotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2).' $';
    }

    /**
     * Get formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2).' $';
    }

    /**
     * Calculate and update item total.
     */
    public function calculateTotal(): void
    {
        $this->total = $this->price * $this->quantity;
        $this->save();
    }

    /**
     * Boot method to handle model events.
     */
    protected static function booted()
    {
        static::saved(function ($item) {
            $item->invoice->calculateTotal();
        });

        static::deleted(function ($item) {
            $item->invoice->calculateTotal();
        });
    }
}
