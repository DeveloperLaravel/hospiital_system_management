<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    /**
     * الحصول على جميع المرضى مع Pagination
     */
    public function getAllPatients(int $perPage = 10)
    {
        return Patient::latest()->paginate($perPage);
    }

    /**
     * الحصول على جميع المرضى بدون ترقيم (للاستخدام في القوائم المنسدلة)
     */
    public function getAllPatientsForSelect()
    {
        return Patient::orderBy('name', 'asc')->get();
    }

    /**
     * إنشاء مريض جديد
     */
    public function createPatient(array $data): Patient
    {
        return Patient::create($data);
    }

    /**
     * تحديث بيانات مريض موجود
     */
    public function updatePatient(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient;
    }

    /**
     * حذف المريض
     */
    public function deletePatient(Patient $patient): void
    {
        $patient->delete();
    }
}
