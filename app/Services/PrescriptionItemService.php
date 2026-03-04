<?php

namespace App\Services;

use App\Models\Medication;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PrescriptionItemService
{
    /**
     * Get all prescription items with relationships.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = PrescriptionItems::with([
            'prescription.medicalRecord.patient',
            'prescription.doctor',
            'medication',
        ]);

        // Apply search filter
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('medication', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('prescription.medicalRecord.patient', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by prescription
        if (! empty($filters['prescription_id'])) {
            $query->where('prescription_id', $filters['prescription_id']);
        }

        // Filter by medication
        if (! empty($filters['medication_id'])) {
            $query->where('medication_id', $filters['medication_id']);
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get prescription items by prescription ID.
     */
    public function getByPrescription(Prescription $prescription): Collection
    {
        return $prescription->items()
            ->with('medication')
            ->get();
    }

    /**
     * Get a single prescription item by ID.
     */
    public function getById(int $id): ?PrescriptionItems
    {
        return PrescriptionItems::with([
            'prescription.medicalRecord.patient',
            'prescription.doctor',
            'medication',
        ])->find($id);
    }

    /**
     * Create a new prescription item.
     */
    public function create(array $data): PrescriptionItems
    {
        return PrescriptionItems::create($data);
    }

    /**
     * Update an existing prescription item.
     */
    public function update(PrescriptionItems $item, array $data): PrescriptionItems
    {
        $item->update($data);

        return $item->fresh();
    }

    /**
     * Delete a prescription item.
     */
    public function delete(PrescriptionItems $item): bool
    {
        return $item->delete();
    }

    /**
     * Get prescription item with full details.
     */
    public function getWithDetails(PrescriptionItems $item): PrescriptionItems
    {
        return $item->load([
            'prescription.medicalRecord.patient',
            'prescription.doctor',
            'prescription.medicalRecord',
            'medication',
        ]);
    }

    /**
     * Get available prescriptions for dropdown.
     */
    public function getAvailablePrescriptions(): Collection
    {
        return Prescription::with(['medicalRecord.patient', 'doctor'])
            ->latest()
            ->get();
    }

    /**
     * Get available medications for dropdown.
     */
    public function getAvailableMedications(): Collection
    {
        return Medication::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Calculate total quantity for a prescription.
     */
    public function getTotalQuantityByPrescription(Prescription $prescription): int
    {
        return $prescription->items()->sum('quantity');
    }

    /**
     * Check if medication is already in prescription.
     */
    public function isMedicationInPrescription(int $prescriptionId, int $medicationId): bool
    {
        return PrescriptionItems::where('prescription_id', $prescriptionId)
            ->where('medication_id', $medicationId)
            ->exists();
    }

    /**
     * Get prescription items grouped by medication.
     */
    public function getItemsGroupedByMedication(Prescription $prescription): Collection
    {
        return $prescription->items()
            ->with('medication')
            ->get()
            ->groupBy('medication_id');
    }

    /**
     * Bulk create prescription items.
     */
    public function bulkCreate(array $items): Collection
    {
        $createdItems = [];
        foreach ($items as $item) {
            $createdItems[] = PrescriptionItems::create($item);
        }

        return collect($createdItems);
    }
}
