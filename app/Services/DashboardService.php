<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardService
{
    public function getStats()
    {
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();

        // المرضى الجدد شهريًا
        $patientsMonthly = Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        // المواعيد خلال الأسبوع
        $appointmentsWeekly = Appointment::selectRaw('DAYNAME(date) as day, COUNT(*) as total')
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('day')
            ->pluck('total', 'day');

        return [
            'patientsCount' => $patientsCount,
            'doctorsCount' => $doctorsCount,
            'appointmentsCount' => $appointmentsCount,
            'patientsMonthly' => $patientsMonthly,
            'appointmentsWeekly' => $appointmentsWeekly,
        ];
    }
}
