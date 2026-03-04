<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MedicalRecordService
{
    /**
     * Get all medical records with optional search
     */
    public function getAll($search = null, $perPage = 10): LengthAwarePaginator
    {
        return MedicalRecord::with(['patient:id,name', 'doctor:id,name'])
            ->when($search, function ($query) use ($search) {
                $query->search($search);
            })
            ->latestFirst()
            ->paginate($perPage);
    }

    /**
     * Get records by patient
     */
    public function getByPatient($patientId)
    {
        return MedicalRecord::with(['doctor'])
            ->byPatient($patientId)
            ->latestFirst()
            ->get();
    }

    /**
     * Get records by doctor
     */
    public function getByDoctor($doctorId)
    {
        return MedicalRecord::with(['patient'])
            ->byDoctor($doctorId)
            ->latestFirst()
            ->get();
    }

    /**
     * Get records by date range
     */
    public function getByDateRange($startDate, $endDate)
    {
        return MedicalRecord::with(['patient', 'doctor'])
            ->dateRange($startDate, $endDate)
            ->latestFirst()
            ->get();
    }

    /**
     * Get patients list
     */
    public function getPatients()
    {
        return Patient::orderBy('name', 'asc')->pluck('name', 'id');
    }

    /**
     * Get doctors list
     */
    public function getDoctors()
    {
        return Doctor::orderBy('name', 'asc')->pluck('name', 'id');
    }

    /**
     * Create a new medical record
     */
    public function create(array $data): MedicalRecord
    {
        return DB::transaction(function () use ($data) {
            return MedicalRecord::create($data);
        });
    }

    /**
     * Alias for create (for backward compatibility)
     */
    public function store(array $data): MedicalRecord
    {
        return $this->create($data);
    }

    /**
     * Update an existing medical record
     */
    public function update(MedicalRecord $medicalRecord, array $data): bool
    {
        return DB::transaction(function () use ($medicalRecord, $data) {
            return $medicalRecord->update($data);
        });
    }

    /**
     * Delete a medical record
     */
    public function delete(MedicalRecord $medicalRecord): bool
    {
        return DB::transaction(function () use ($medicalRecord) {
            return $medicalRecord->delete();
        });
    }

    /**
     * Get medical record statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => MedicalRecord::count(),
            'today' => MedicalRecord::whereDate('visit_date', now()->toDateString())->count(),
            'this_week' => MedicalRecord::whereBetween('visit_date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])->count(),
            'this_month' => MedicalRecord::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->count(),
        ];
    }
}
