<?php

namespace App\Services;

use App\Models\Medication;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicationService
{
    /**
     * Get all medications with pagination
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Medication::latest()->paginate($perPage);
    }

    /**
     * Search medications
     */
    public function search(string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Medication::search($search)->latest()->paginate($perPage);
    }

    /**
     * Get medications with low stock
     */
    public function getLowStock(): \Illuminate\Database\Eloquent\Collection
    {
        return Medication::whereRaw('quantity <= min_stock')
            ->orWhere('quantity', '<=', 5)
            ->get();
    }

    /**
     * Get expiring soon medications (within 30 days)
     */
    public function getExpiringSoon(): \Illuminate\Database\Eloquent\Collection
    {
        return Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->get();
    }

    /**
     * Get expired medications
     */
    public function getExpired(): \Illuminate\Database\Eloquent\Collection
    {
        return Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->get();
    }

    /**
     * Get active medications
     */
    public function getActive(int $perPage = 10): LengthAwarePaginator
    {
        return Medication::where('is_active', true)->latest()->paginate($perPage);
    }

    /**
     * Create new medication
     */
    public function create(array $data): Medication
    {
        return Medication::create($data);
    }

    /**
     * Update medication
     */
    public function update(Medication $medication, array $data): Medication
    {
        $medication->update($data);

        return $medication->fresh();
    }

    /**
     * Delete medication
     */
    public function delete(Medication $medication): bool
    {
        return $medication->delete();
    }

    /**
     * Update quantity (for transactions)
     */
    public function updateQuantity(Medication $medication, int $quantity, string $type): bool
    {
        if ($type === 'in') {
            $medication->increment('quantity', $quantity);
        } elseif ($type === 'out') {
            if ($medication->quantity < $quantity) {
                return false;
            }
            $medication->decrement('quantity', $quantity);
        }

        return true;
    }

    /**
     * Check if medication is available
     */
    public function isAvailable(Medication $medication, int $quantity = 1): bool
    {
        return $medication->is_active && $medication->quantity >= $quantity;
    }

    /**
     * Get medication statistics
     */
    public function getStats(): array
    {
        return [
            'total' => Medication::count(),
            'active' => Medication::where('is_active', true)->count(),
            'inactive' => Medication::where('is_active', false)->count(),
            'low_stock' => Medication::whereRaw('quantity <= min_stock')->count(),
            'expiring_soon' => Medication::whereNotNull('expiry_date')
                ->where('expiry_date', '<=', now()->addDays(30))
                ->where('expiry_date', '>=', now())
                ->count(),
            'expired' => Medication::whereNotNull('expiry_date')
                ->where('expiry_date', '<', now())
                ->count(),
        ];
    }
}
