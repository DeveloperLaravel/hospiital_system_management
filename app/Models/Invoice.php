<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total',
        'status',
        'notes',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'decimal:2',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the invoice.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the items for the invoice.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Scope a query to only include overdue invoices.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'unpaid')
            ->where('due_date', '<', now());
    }

    /**
     * Scope a query to filter by patient.
     */
    public function scopeByPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('invoice_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to search by invoice number or patient name.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('invoice_number', 'like', "%{$search}%")
                ->orWhereHas('patient', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    /**
     * Get the patient name.
     */
    public function getPatientNameAttribute(): string
    {
        return $this->patient?->name ?? '-';
    }

    /**
     * Get formatted status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'مدفوعة',
            'unpaid' => 'غير مدفوعة',
            'partial' => 'مدفوعة جزئياً',
            'cancelled' => 'ملغاة',
            default => '-',
        };
    }

    /**
     * Get formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2).' $';
    }

    /**
     * Get formatted invoice date.
     */
    public function getFormattedInvoiceDateAttribute(): string
    {
        return $this->invoice_date?->format('Y-m-d') ?? '-';
    }

    /**
     * Get formatted due date.
     */
    public function getFormattedDueDateAttribute(): string
    {
        return $this->due_date?->format('Y-m-d') ?? '-';
    }

    /**
     * Check if invoice is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if invoice is unpaid.
     */
    public function isUnpaid(): bool
    {
        return $this->status === 'unpaid';
    }

    /**
     * Check if invoice is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'unpaid' && $this->due_date && $this->due_date->isPast();
    }

    /**
     * Calculate total from items.
     */
    public function calculateTotal(): void
    {
        $this->total = $this->items->sum(fn ($item) => $item->price * $item->quantity);
        $this->save();
    }

    /**
     * Generate invoice number.
     */
    public static function generateNumber(): string
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;

        return 'INV-'.date('Y').'-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
