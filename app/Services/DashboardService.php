<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Room;

class DashboardService
{
    public function getStats()
    {
        // إحصائيات أساسية
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();
        $prescriptionsCount = Prescription::count();
        $medicationsCount = Medication::count();
        $roomsCount = Room::count();
        $medicalRecordsCount = MedicalRecord::count();
        $invoicesCount = Invoice::count();

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

        // المواعيد اليوم
        $todayAppointments = Appointment::whereDate('date', now()->toDateString())->count();

        // مواعيد الغد
        $tomorrowAppointments = Appointment::whereDate('date', now()->addDay()->toDateString())->count();

        // مواعيد مؤكدة
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();

        // مواعيد مكتملة
        $completedAppointments = Appointment::where('status', 'completed')->count();

        // مواعيد معلقة
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // الغرف المشغولة
        $occupiedRooms = Room::where('status', 'occupied')->count();

        // الغرف المتاحة
        $availableRooms = Room::where('status', 'available')->count();

        // الأدوية منخفضة المخزون
        $lowStockMedications = Medication::whereRaw('quantity <= min_stock')->count();

        // الأدوية المنتهية الصلاحية قريباً
        $expiringMedications = Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();

        // المرضى الجدد هذا الأسبوع
        $newPatientsThisWeek = Patient::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // السجلات الطبية هذا الشهر
        $medicalRecordsThisMonth = MedicalRecord::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // الوصفات الطبية هذا الشهر
        $prescriptionsThisMonth = Prescription::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // إجمالي الإيرادات
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount') ?? 0;

        // الإيرادات هذا الشهر
        $revenueThisMonth = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount') ?? 0;

        // آخر المرضى
        $recentPatients = Patient::latest()->take(5)->get();

        // آخر المواعيد
        $recentAppointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        // أحدث الوصفات
        $recentPrescriptions = Prescription::with(['medicalRecord.patient', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        return [
            // إحصائيات أساسية
            'patientsCount' => $patientsCount,
            'doctorsCount' => $doctorsCount,
            'appointmentsCount' => $appointmentsCount,
            'prescriptionsCount' => $prescriptionsCount,
            'medicationsCount' => $medicationsCount,
            'roomsCount' => $roomsCount,
            'medicalRecordsCount' => $medicalRecordsCount,
            'invoicesCount' => $invoicesCount,

            // رسوموم بياني
            'patientsMonthly' => $patientsMonthly,
            'appointmentsWeekly' => $appointmentsWeekly,

            // مواعيد
            'todayAppointments' => $todayAppointments,
            'tomorrowAppointments' => $tomorrowAppointments,
            'confirmedAppointments' => $confirmedAppointments,
            'completedAppointments' => $completedAppointments,
            'pendingAppointments' => $pendingAppointments,

            // غرف
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,

            // أدوية
            'lowStockMedications' => $lowStockMedications,
            'expiringMedications' => $expiringMedications,

            // أنشطة
            'newPatientsThisWeek' => $newPatientsThisWeek,
            'medicalRecordsThisMonth' => $medicalRecordsThisMonth,
            'prescriptionsThisMonth' => $prescriptionsThisMonth,

            // مالية
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,

            // بيانات حديثة
            'recentPatients' => $recentPatients,
            'recentAppointments' => $recentAppointments,
            'recentPrescriptions' => $recentPrescriptions,

            // نسبة الإشغال
            'roomOccupancyRate' => $roomsCount > 0 ? round(($occupiedRooms / $roomsCount) * 100) : 0,
        ];
    }
}
