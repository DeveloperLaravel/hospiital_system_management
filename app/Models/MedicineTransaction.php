<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'medication_id',
        'type',
        'quantity',
        'user_id',
        'reference_number',
        'notes',
        'transaction_date',
        'prescription_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'transaction_date' => 'date',
    ];

    /**
     * Get the medication that owns the transaction.
     */
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    /**
     * Get the user that created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prescription associated with the transaction.
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Scope a query to only include inbound transactions.
     */
    public function scopeInbound($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope a query to only include outbound transactions.
     */
    public function scopeOutbound($query)
    {
        return $query->where('type', 'out');
    }

    /**
     * Scope a query to filter by medication.
     */
    public function scopeByMedication($query, $medicationId)
    {
        return $query->where('medication_id', $medicationId);
    }

    /**
     * Scope a query to order by latest.
     */
    public function scopeLatestFirst($query)
    {
        return $query->latest();
    }

    /**
     * Scope a query to search by medication or user name.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('medication', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    /**
     * Get the medication name.
     */
    public function getMedicationNameAttribute(): string
    {
        return $this->medication?->name ?? '-';
    }

    /**
     * Get the user name.
     */
    public function getUserNameAttribute(): string
    {
        return $this->user?->name ?? '-';
    }

    /**
     * Get formatted transaction type.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'in' => 'إدخال',
            'out' => 'إخراج',
            default => '-',
        };
    }

    /**
     * Get formatted quantity with sign.
     */
    public function getFormattedQuantityAttribute(): string
    {
        $sign = $this->type === 'in' ? '+' : '-';

        return $sign.$this->quantity;
    }

    /**
     * Get formatted transaction date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('Y-m-d');
    }

    /**
     * Check if transaction is inbound.
     */
    public function isInbound(): bool
    {
        return $this->type === 'in';
    }

    /**
     * Check if transaction is outbound.
     */
    public function isOutbound(): bool
    {
        return $this->type === 'out';
    }

    /**
     * Get the transaction balance (cumulative).
     */
    public static function getMedicationBalance(int $medicationId): int
    {
        $inbound = self::where('medication_id', $medicationId)
            ->where('type', 'in')
            ->sum('quantity');

        $outbound = self::where('medication_id', $medicationId)
            ->where('type', 'out')
            ->sum('quantity');

        return $inbound - $outbound;
    }
}
