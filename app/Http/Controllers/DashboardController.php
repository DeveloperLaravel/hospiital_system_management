<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function __invoke()
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

        return view('dashboard', compact(
            'patientsCount',
            'doctorsCount',
            'appointmentsCount',
            'patientsMonthly',
            'appointmentsWeekly'
            // 'billsCount'
        ));
    }
}
