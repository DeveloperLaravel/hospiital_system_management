<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;

class MedicalRecordService
{
    public function getAll()
    {
        return MedicalRecord::with(['patient', 'doctor'])
            ->latest()
            ->paginate(5);
    }

    public function getPatients()
    {
        return Patient::all();
    }

    public function getDoctors()
    {
        return Doctor::with('department')->get();
    }

    public function store(array $data)
    {
        return MedicalRecord::create($data);
    }

    public function update(MedicalRecord $medicalRecord, array $data)
    {
        return $medicalRecord->update($data);
    }

    public function delete(MedicalRecord $medicalRecord)
    {
        return $medicalRecord->delete();
    }
}
