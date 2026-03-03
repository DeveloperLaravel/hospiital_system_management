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
     * البحث والفلترة للمرضى
     */
    public function searchPatients(array $filters, int $perPage = 15)
    {
        $query = Patient::query();

        // البحث بالاسم أو رقم الهوية أو الهاتف
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // فلترة حسب الجنس
        if (! empty($filters['gender'])) {
            $query->gender($filters['gender']);
        }

        // فلترة حسب فصيلة الدم
        if (! empty($filters['blood_type'])) {
            $query->bloodType($filters['blood_type']);
        }

        // فلترة حسب حالة الرصيد
        if (! empty($filters['balance_status'])) {
            match ($filters['balance_status']) {
                'with_balance' => $query->withBalance(),
                'overdue' => $query->overdue(),
                'no_limit' => $query->noCreditLimit(),
                default => $query,
            };
        }

        return $query->latest()->paginate($perPage);
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
        // تعيين القيم الافتراضية للحقول المالية
        $data['balance'] = $data['balance'] ?? 0;
        $data['total_paid'] = $data['total_paid'] ?? 0;
        $data['credit_limit'] = $data['credit_limit'] ?? 0;

        return Patient::create($data);
    }

    /**
     * تحديث بيانات مريض موجود
     */
    public function updatePatient(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient->fresh();
    }

    /**
     * حذف المريض
     */
    public function deletePatient(Patient $patient): void
    {
        $patient->delete();
    }

    /**
     * إضافة دفعة للمريض
     */
    public function addPayment(Patient $patient, float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('مبلغ الدفعة يجب أن يكون أكبر من صفر');
        }

        $patient->addPayment($amount);
    }

    /**
     * إضافة رسوم للمريض
     */
    public function addCharge(Patient $patient, float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('مبلغ الرسوم يجب أن يكون أكبر من صفر');
        }

        $patient->addCharge($amount);
    }

    /**
     * تحديث الحد الائتماني للمريض
     */
    public function updateCreditLimit(Patient $patient, float $limit): void
    {
        $patient->update(['credit_limit' => $limit]);
    }

    /**
     * الحصول على إحصائيات المرضى
     */
    public function getStatistics(): array
    {
        $totalPatients = Patient::count();
        $malePatients = Patient::where('gender', 'male')->count();
        $femalePatients = Patient::where('gender', 'female')->count();

        $totalBalance = Patient::sum('balance');
        $totalPaid = Patient::sum('total_paid');

        $patientsWithBalance = Patient::where('balance', '>', 0)->count();
        $overduePatients = Patient::whereColumn('balance', '>', 'credit_limit')
            ->where('credit_limit', '>', 0)->count();

        return [
            'total_patients' => $totalPatients,
            'male_patients' => $malePatients,
            'female_patients' => $femalePatients,
            'total_balance' => $totalBalance,
            'total_paid' => $totalPaid,
            'patients_with_balance' => $patientsWithBalance,
            'overdue_patients' => $overduePatients,
            'formatted_total_balance' => number_format($totalBalance, 2).' ₽',
            'formatted_total_paid' => number_format($totalPaid, 2).' ₽',
        ];
    }

    /**
     * الحصول على مريض واحد بالتفاصيل
     */
    public function getPatientWithDetails(int $id): ?Patient
    {
        return Patient::with([
            'appointments',
            'medicalRecords',
            'invoices',
            'prescriptions',
            'rooms',
        ])->find($id);
    }

    /**
     * البحث عن مريض بالاسم أو رقم الهاتف
     */
    public function searchPatientsSimple(string $term)
    {
        return Patient::search($term)
            ->limit(10)
            ->get(['id', 'name', 'national_id', 'phone', 'balance']);
    }
}
