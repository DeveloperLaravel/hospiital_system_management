<?php

namespace App\Services;

use App\Models\Prescription;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    /**
     * Create a new prescription with items
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $prescription = Prescription::create([
                'medical_record_id' => $data['medical_record_id'],
                'doctor_id' => $data['doctor_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $prescription->items()->create($item);
            }

            return $prescription;
        });
    }

    /**
     * Update an existing prescription
     */
    public function update(Prescription $prescription, array $data)
    {
        return DB::transaction(function () use ($prescription, $data) {
            $prescription->update([
                'medical_record_id' => $data['medical_record_id'],
                'doctor_id' => $data['doctor_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Delete old items and create new ones
            $prescription->items()->delete();

            foreach ($data['items'] as $item) {
                $prescription->items()->create($item);
            }

            return $prescription;
        });
    }

    /**
     * Delete a prescription
     */
    public function delete(Prescription $prescription)
    {
        // Delete related items first
        $prescription->items()->delete();

        return $prescription->delete();
    }

    /**
     * Get all prescriptions with search
     */
    public function getAll($search = null, $perPage = 10)
    {
        return Prescription::withRelations()
            ->search($search)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get prescription by ID
     */
    public function getById($id)
    {
        return Prescription::withRelations()->findOrFail($id);
    }

    /**
     * Get prescriptions by patient
     */
    public function getByPatient($patientId)
    {
        return Prescription::withRelations()
            ->byPatient($patientId)
            ->latest()
            ->get();
    }

    /**
     * Get prescriptions by doctor
     */
    public function getByDoctor($doctorId)
    {
        return Prescription::withRelations()
            ->byDoctor($doctorId)
            ->latest()
            ->get();
    }
}
