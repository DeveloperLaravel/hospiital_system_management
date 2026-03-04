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
    /**
     * Get all dashboard statistics
     */
    public function getStats(): array
    {
        return array_merge(
            $this->getBasicStats(),
            $this->getAppointmentsStats(),
            $this->getRoomsStats(),
            $this->getMedicationsStats(),
            $this->getActivityStats(),
            $this->getFinancialStats(),
            $this->getRecentData()
        );
    }

    /**
     * الإحصائيات الأساسية - Basic Statistics
     */
    protected function getBasicStats(): array
    {
        return [
            'patientsCount' => Patient::count(),
            'doctorsCount' => Doctor::count(),
            'appointmentsCount' => Appointment::count(),
            'prescriptionsCount' => Prescription::count(),
            'medicationsCount' => Medication::count(),
            'roomsCount' => Room::count(),
            'medicalRecordsCount' => MedicalRecord::count(),
            'invoicesCount' => Invoice::count(),
        ];
    }

    /**
     * إحصائيات المواعيد - Appointments Statistics
     */
    protected function getAppointmentsStats(): array
    {
        return [
            // رسوم بيانية
            'patientsMonthly' => $this->getPatientsMonthlyChart(),
            'appointmentsWeekly' => $this->getAppointmentsWeeklyChart(),

            // مواعيد
            'todayAppointments' => Appointment::whereDate('date', now()->toDateString())->count(),
            'tomorrowAppointments' => Appointment::whereDate('date', now()->addDay()->toDateString())->count(),
            'confirmedAppointments' => Appointment::where('status', 'confirmed')->count(),
            'completedAppointments' => Appointment::where('status', 'completed')->count(),
            'pendingAppointments' => Appointment::where('status', 'pending')->count(),
        ];
    }

    /**
     * إحصائيات الغرف - Rooms Statistics
     */
    protected function getRoomsStats(): array
    {
        $roomsCount = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        return [
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => Room::where('status', 'available')->count(),
            'roomOccupancyRate' => $roomsCount > 0 ? round(($occupiedRooms / $roomsCount) * 100) : 0,
        ];
    }

    /**
     * إحصائيات الأدوية - Medications Statistics
     */
    protected function getMedicationsStats(): array
    {
        return [
            'lowStockMedications' => Medication::whereRaw('quantity <= min_stock')->count(),
            'expiringMedications' => Medication::whereNotNull('expiry_date')
                ->where('expiry_date', '<=', now()->addDays(30))
                ->where('expiry_date', '>=', now())
                ->count(),
        ];
    }

    /**
     * إحصائيات الأنشطة - Activity Statistics
     */
    protected function getActivityStats(): array
    {
        return [
            'newPatientsThisWeek' => Patient::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'medicalRecordsThisMonth' => MedicalRecord::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'prescriptionsThisMonth' => Prescription::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    /**
     * الإحصائيات المالية - Financial Statistics
     */
    protected function getFinancialStats(): array
    {
        return [
            'totalRevenue' => Invoice::paid()->sum('total') ?? 0,
            'revenueThisMonth' => Invoice::paid()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total') ?? 0,
            'unpaidRevenue' => Invoice::unpaid()->sum('total') ?? 0,
            'overdueInvoices' => Invoice::overdue()->count(),
            'averageInvoiceValue' => Invoice::avg('total') ?? 0,
        ];
    }

    /**
     * البيانات الحديثة - Recent Data
     */
    protected function getRecentData(): array
    {
        return [
            'recentPatients' => Patient::latest()->take(5)->get(),
            'recentAppointments' => Appointment::with(['patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
            'recentPrescriptions' => Prescription::with(['medicalRecord.patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

    /**
     * رسم بياني للمرضى الجدد شهرياً
     */
    protected function getPatientsMonthlyChart()
    {
        return Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');
    }

    /**
     * رسم بياني للمواعيد خلال الأسبوع
     */
    protected function getAppointmentsWeeklyChart()
    {
        return Appointment::selectRaw('DAYNAME(date) as day, COUNT(*) as total')
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('day')
            ->pluck('total', 'day');
    }
}
