<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Room;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardManager extends Component
{
    /**
     * الوقت بين التحديث التلقائي (بالثواني)
     */
    public int $refreshInterval = 30;

    /**
     * نطاق التاريخ للفلترة
     */
    public string $dateRange = 'today';

    /**
     * البحث
     */
    public string $search = '';

    /**
     * تصفية حسب القسم
     */
    public ?int $departmentFilter = null;

    /**
     * ترتيب البيانات
     */
    public string $sortBy = 'newest';

    public string $sortDirection = 'desc';

    /**
     * عرض التقارير
     */
    public bool $showReports = false;

    /**
     *科室التحديث اليدوي للبيانات
     */
    public function refreshData(): void
    {
        $this->dispatch('refresh-charts');
    }

    /**
     * تغيير نطاق التاريخ
     */
    public function setDateRange(string $range): void
    {
        $this->dateRange = $range;
        $this->dispatch('date-range-changed', $range);
    }

    /**
     * تصدير البيانات
     */
    public function exportData(string $type): void
    {
        $data = match ($type) {
            'patients' => $this->recentPatients,
            'appointments' => $this->recentAppointments,
            default => []
        };

        $this->dispatch('export-data', type: $type, data: $data);
    }

    /**
     *_getBasicStats الإحصائيات الأساسية
     */
    #[Computed]
    public function basicStats(): array
    {
        return [
            'patients' => Patient::count(),
            'doctors' => Doctor::count(),
            'appointments' => Appointment::count(),
            'prescriptions' => Prescription::count(),
            'medications' => Medication::count(),
            'rooms' => Room::count(),
            'medicalRecords' => MedicalRecord::count(),
            'invoices' => Invoice::count(),
        ];
    }

    /**
     * إحصائيات المواعيد
     */
    #[Computed]
    public function appointmentsStats(): array
    {
        $baseQuery = Appointment::query();

        return match ($this->dateRange) {
            'today' => [
                'today' => $baseQuery->whereDate('date', today())->count(),
                'tomorrow' => Appointment::whereDate('date', today()->addDay())->count(),
                'thisWeek' => $baseQuery->whereBetween('date', [today(), today()->addWeek()])->count(),
                'thisMonth' => $baseQuery->whereMonth('date', now()->month)->count(),
            ],
            'week' => [
                'today' => $baseQuery->whereDate('date', today())->count(),
                'tomorrow' => Appointment::whereDate('date', today()->addDay())->count(),
                'thisWeek' => $baseQuery->whereBetween('date', [today()->startOfWeek(), today()->endOfWeek()])->count(),
                'thisMonth' => $baseQuery->whereMonth('date', now()->month)->count(),
            ],
            default => [
                'today' => Appointment::whereDate('date', today())->count(),
                'tomorrow' => Appointment::whereDate('date', today()->addDay())->count(),
                'thisWeek' => Appointment::whereBetween('date', [today(), today()->addWeek()])->count(),
                'thisMonth' => Appointment::whereMonth('date', now()->month)->count(),
            ],
        };
    }

    /**
     * إحصائيات الغرف
     */
    #[Computed]
    public function roomsStats(): array
    {
        $total = Room::count();
        $occupied = Room::where('status', 'occupied')->count();
        $available = Room::where('status', 'available')->count();
        $maintenance = Room::where('status', 'maintenance')->count();

        return [
            'total' => $total,
            'occupied' => $occupied,
            'available' => $available,
            'maintenance' => $maintenance,
            'occupancyRate' => $total > 0 ? round(($occupied / $total) * 100) : 0,
        ];
    }

    /**
     * إحصائيات الأدوية
     */
    #[Computed]
    public function medicationsStats(): array
    {
        $lowStock = Medication::whereRaw('quantity <= min_stock')->count();
        $expiringSoon = Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();
        $expired = Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->count();

        return [
            'total' => Medication::count(),
            'lowStock' => $lowStock,
            'expiringSoon' => $expiringSoon,
            'expired' => $expired,
        ];
    }

    /**
     * الإحصائيات المالية
     */
    #[Computed]
    public function financialStats(): array
    {
        $paidInvoices = Invoice::paid();
        $unpaidInvoices = Invoice::unpaid();
        $overdueInvoices = Invoice::overdue();

        return [
            'totalRevenue' => $paidInvoices->sum('total') ?? 0,
            'revenueToday' => $paidInvoices->whereDate('created_at', today())->sum('total') ?? 0,
            'revenueThisWeek' => $paidInvoices->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->sum('total') ?? 0,
            'revenueThisMonth' => $paidInvoices->whereMonth('created_at', now()->month)->sum('total') ?? 0,
            'unpaidAmount' => $unpaidInvoices->sum('total') ?? 0,
            'overdueAmount' => $overdueInvoices->sum('total') ?? 0,
            'overdueCount' => $overdueInvoices->count(),
            'averageInvoice' => Invoice::avg('total') ?? 0,
        ];
    }

    /**
     * إحصائيات الأنشطة
     */
    #[Computed]
    public function activityStats(): array
    {
        return [
            'newPatientsThisWeek' => Patient::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'newPatientsThisMonth' => Patient::whereMonth('created_at', now()->month)->count(),
            'medicalRecordsThisMonth' => MedicalRecord::whereMonth('created_at', now()->month)->count(),
            'prescriptionsThisMonth' => Prescription::whereMonth('created_at', now()->month)->count(),
        ];
    }

    /**
     * آخر المرضى
     */
    #[Computed]
    public function recentPatients()
    {
        $query = Patient::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('national_id', 'like', "%{$this->search}%");
            });
        }

        return $query->latest()
            ->take(10)
            ->get();
    }

    /**
     * آخر المواعيد
     */
    #[Computed]
    public function recentAppointments()
    {
        return Appointment::with(['patient', 'doctor', 'doctor.department'])
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->take(10)
            ->get();
    }

    /**
     * بيانات الرسم البياني للمرضى
     */
    #[Computed]
    public function patientsChartData(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return [
                'month' => $month,
                'label' => \Carbon\Carbon::create(null, $month, 1)->format('F'),
                'count' => Patient::whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
        });

        return [
            'labels' => $months->pluck('label')->toArray(),
            'data' => $months->pluck('count')->toArray(),
        ];
    }

    /**
     * بيانات الرسم البياني للمواعيد
     */
    #[Computed]
    public function appointmentsChartData(): array
    {
        // 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
        $days = [0, 1, 2, 3, 4, 5, 6];
        $daysArabic = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $data = collect($days)->map(function ($day) use ($startOfWeek, $endOfWeek) {
            return Appointment::whereRaw('DAYOFWEEK(date) = ?', [$day + 1])
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->count();
        });

        return [
            'labels' => $daysArabic,
            'data' => $data->toArray(),
        ];
    }

    /**
     * بيانات الرسم البياني للدوائر
     */
    #[Computed]
    public function distributionChartData(): array
    {
        return [
            'patients' => Patient::count(),
            'doctors' => Doctor::count(),
            'appointments' => Appointment::count(),
            'medications' => Medication::count(),
            'rooms' => Room::count(),
        ];
    }

    /**
     * بيانات الرسم البياني للإيرادات
     */
    #[Computed]
    public function revenueChartData(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return Invoice::paid()
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->sum('total') ?? 0;
        });

        return [
            'labels' => collect(range(1, 12))->map(function ($m) {
                return \Carbon\Carbon::create(null, $m, 1)->format('F');
            })->toArray(),
            'data' => $months->toArray(),
        ];
    }

    /**
     * تنبيهات المخزون
     */
    #[Computed]
    public function alerts(): array
    {
        $alerts = [];

        // أدوية منخفضة المخزون
        $lowStock = Medication::whereRaw('quantity <= min_stock')->get();
        if ($lowStock->count() > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'أدوية منخفضة المخزون',
                'message' => $lowStock->count().' أدوية تحتاج لإعادة التخزين',
                'icon' => '💊',
                'items' => $lowStock->take(5)->pluck('name')->toArray(),
            ];
        }

        // أدوية تنتهي قريباً
        $expiring = Medication::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->get();
        if ($expiring->count() > 0) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'أدوية تنتهي قريباً',
                'message' => $expiring->count().' أدوية تنتهي خلال 30 يوم',
                'icon' => '⏰',
                'items' => $expiring->take(5)->pluck('name')->toArray(),
            ];
        }

        // فواتير متأخرة
        $overdue = Invoice::overdue()->count();
        if ($overdue > 0) {
            $alerts[] = [
                'type' => 'error',
                'title' => 'فواتير متأخرة',
                'message' => $overdue.' فواتير متأخرة الدفع',
                'icon' => '⚠️',
                'items' => [],
            ];
        }

        // غرف تحتاج صيانة
        $maintenance = Room::where('status', 'maintenance')->count();
        if ($maintenance > 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'غرف تحت الصيانة',
                'message' => $maintenance.' غرف تحتاج صيانة',
                'icon' => '🔧',
                'items' => [],
            ];
        }

        return $alerts;
    }

    /**
     * قائمة الأقسام
     */
    #[Computed]
    public function departments()
    {
        return \App\Models\Department::all(['id', 'name']);
    }

    /**
     * الـ render الرئيسي
     */
    public function render()
    {
        return view('livewire.dashboard-manager', [
            'basicStats' => $this->basicStats,
            'appointmentsStats' => $this->appointmentsStats,
            'roomsStats' => $this->roomsStats,
            'medicationsStats' => $this->medicationsStats,
            'financialStats' => $this->financialStats,
            'activityStats' => $this->activityStats,
            'recentPatients' => $this->recentPatients,
            'recentAppointments' => $this->recentAppointments,
            'patientsChartData' => $this->patientsChartData,
            'appointmentsChartData' => $this->appointmentsChartData,
            'distributionChartData' => $this->distributionChartData,
            'revenueChartData' => $this->revenueChartData,
            'alerts' => $this->alerts,
            'departments' => $this->departments,
        ]);
    }
}
