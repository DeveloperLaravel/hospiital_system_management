<?php

namespace App\Services;

use App\Models\Medication;
use App\Models\MedicineTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicineTransactionService
{
    /**
     * Get all transactions with relationships.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = MedicineTransaction::with(['medication', 'user']);

        // Apply search filter
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter by type
        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Filter by medication
        if (! empty($filters['medication_id'])) {
            $query->byMedication($filters['medication_id']);
        }

        // Filter by date range
        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->latestFirst()->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get a single transaction by ID.
     */
    public function getById(int $id): ?MedicineTransaction
    {
        return MedicineTransaction::with(['medication', 'user'])->find($id);
    }

    /**
     * Create a new transaction.
     */
    public function create(array $data): MedicineTransaction
    {
        $transaction = MedicineTransaction::create([
            'medication_id' => $data['medication_id'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'user_id' => $data['user_id'] ?? auth()->id(),
        ]);

        // Update medication stock
        $this->updateMedicationStock($transaction);

        return $transaction;
    }

    /**
     * Update an existing transaction.
     */
    public function update(MedicineTransaction $transaction, array $data): MedicineTransaction
    {
        // Reverse old stock change
        $this->reverseMedicationStock($transaction);

        // Update transaction
        $transaction->update([
            'medication_id' => $data['medication_id'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
        ]);

        // Apply new stock change
        $this->updateMedicationStock($transaction);

        return $transaction->fresh();
    }

    /**
     * Delete a transaction.
     */
    public function delete(MedicineTransaction $transaction): bool
    {
        // Reverse stock before deletion
        $this->reverseMedicationStock($transaction);

        return $transaction->delete();
    }

    /**
     * Get transaction with full details.
     */
    public function getWithDetails(MedicineTransaction $transaction): MedicineTransaction
    {
        return $transaction->load(['medication', 'user']);
    }

    /**
     * Get available medications for dropdown.
     */
    public function getAvailableMedications(): Collection
    {
        return Medication::orderBy('name')->get();
    }

    /**
     * Get transactions by medication.
     */
    public function getByMedication(Medication $medication): Collection
    {
        return $medication->transactions()
            ->with('user')
            ->latestFirst()
            ->get();
    }

    /**
     * Get medication balance.
     */
    public function getMedicationBalance(int $medicationId): int
    {
        return MedicineTransaction::getMedicationBalance($medicationId);
    }

    /**
     * Get transactions statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = MedicineTransaction::query();

        if (! empty($filters['medication_id'])) {
            $query->where('medication_id', $filters['medication_id']);
        }

        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        $totalIn = (clone $query)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $query)->where('type', 'out')->sum('quantity');
        $balance = $totalIn - $totalOut;

        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'balance' => $balance,
            'transaction_count' => (clone $query)->count(),
        ];
    }

    /**
     * Update medication stock after transaction.
     */
    protected function updateMedicationStock(MedicineTransaction $transaction): void
    {
        $medication = $transaction->medication;
        if (! $medication) {
            return;
        }

        $currentStock = $medication->stock_quantity ?? 0;

        if ($transaction->type === 'in') {
            $medication->update(['stock_quantity' => $currentStock + $transaction->quantity]);
        } else {
            $newStock = max(0, $currentStock - $transaction->quantity);
            $medication->update(['stock_quantity' => $newStock]);
        }
    }

    /**
     * Reverse medication stock change.
     */
    protected function reverseMedicationStock(MedicineTransaction $transaction): void
    {
        $medication = $transaction->medication;
        if (! $medication) {
            return;
        }

        $currentStock = $medication->stock_quantity ?? 0;

        if ($transaction->type === 'in') {
            $newStock = max(0, $currentStock - $transaction->quantity);
            $medication->update(['stock_quantity' => $newStock]);
        } else {
            $medication->update(['stock_quantity' => $currentStock + $transaction->quantity]);
        }
    }
}
