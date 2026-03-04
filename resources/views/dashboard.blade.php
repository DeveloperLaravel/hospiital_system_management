<x-app-layout>
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-2 mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        لوحة تحكم المستشفى 🏥
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        مرحباً بك! إليك ملخص شامل لجميع إحصائيات المستشفى
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ now()->locale('ar')->format('l j F Y') }}
                </div>
            </div>

            <!-- Stats Cards Row 1 -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Patients -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">المرضى</p>
                            <p class="text-3xl font-bold mt-1">{{ $patientsCount ?? 0 }}</p>
                            <p class="text-blue-100 text-xs mt-1">مريض جديد: {{ $newPatientsThisWeek ?? 0 }} هذا الأسبوع</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                </div>

                <!-- Doctors -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm">الأطباء</p>
                            <p class="text-3xl font-bold mt-1">{{ $doctorsCount ?? 0 }}</p>
                            <p class="text-emerald-100 text-xs mt-1">مؤكد: {{ $confirmedAppointments ?? 0 }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🩺</span>
                        </div>
                    </div>
                </div>

                <!-- Appointments -->
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm">المواعيد</p>
                            <p class="text-3xl font-bold mt-1">{{ $appointmentsCount ?? 0 }}</p>
                            <p class="text-amber-100 text-xs mt-1">اليوم: {{ $todayAppointments ?? 0 }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                </div>

                <!-- Rooms -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">الغرف</p>
                            <p class="text-3xl font-bold mt-1">{{ $roomsCount ?? 0 }}</p>
                            <p class="text-purple-100 text-xs mt-1">مشغولة: {{ $occupiedRooms ?? 0 }} ({{ $roomOccupancyRate ?? 0 }}%)</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🏨</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 2 -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Medications -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الأدوية</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $medicationsCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">💊</span>
                        </div>
                    </div>
                    @if(($lowStockMedications ?? 0) > 0)
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            {{ $lowStockMedications }} منخفض المخزون
                        </p>
                    @endif
                </div>

                <!-- Prescriptions -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الوصفات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $prescriptionsCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">📋</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ $prescriptionsThisMonth ?? 0 }} هذا الشهر</p>
                </div>

                <!-- Medical Records -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">السجلات الطبية</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $medicalRecordsCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">📁</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ $medicalRecordsThisMonth ?? 0 }} هذا الشهر</p>
                </div>

                <!-- Revenue -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الإيرادات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalRevenue ?? 0, 0) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">💰</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ number_format($revenueThisMonth ?? 0, 0) }} هذا الشهر</p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                <!-- Patients Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">المرضى شهرياً</h3>
                    <canvas id="patientsChart" height="200"></canvas>
                </div>

                <!-- Appointments Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">المواعيد الأسبوعية</h3>
                    <canvas id="appointmentsChart" height="200"></canvas>
                </div>

                <!-- Distribution Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">نظرة عامة</h3>
                    <canvas id="distributionChart" height="200"></canvas>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Patients -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">آخر المرضى</h3>
                        <a href="{{ route('patients.index') }}" class="text-blue-600 text-sm hover:underline">عرض الكل</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="p-3 text-right">الاسم</th>
                                    <th class="p-3 text-right">الهاتف</th>
                                    <th class="p-3 text-right">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($recentPatients as $patient)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $patient->name }}</td>
                                    <td class="p-3 text-gray-500">{{ $patient->phone ?? '-' }}</td>
                                    <td class="p-3 text-gray-400">{{ $patient->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-400">لا توجد بيانات</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">آخر المواعيد</h3>
                        <a href="{{ route('appointments.index') }}" class="text-blue-600 text-sm hover:underline">عرض الكل</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="p-3 text-right">المريض</th>
                                    <th class="p-3 text-right">الطبيب</th>
                                    <th class="p-3 text-right">الحالة</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($recentAppointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $appointment->patient->name ?? '-' }}</td>
                                    <td class="p-3 text-gray-500">{{ $appointment->doctor->name ?? '-' }}</td>
                                    <td class="p-3">
                                        @switch($appointment->status)
                                            @case('pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">معلق</span>
                                                @break
                                            @case('confirmed')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">مؤكد</span>
                                                @break
                                            @case('completed')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">مكتمل</span>
                                                @break
                                            @case('cancelled')
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">ملغي</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-400">لا توجد مواعيد</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Alerts Section -->
            @if(($lowStockMedications > 0) || ($expiringMedications > 0))
            <div class="mt-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        تنبيهات المخزون
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($lowStockMedications > 0)
                        <div class="flex items-center gap-3 bg-white p-4 rounded-xl">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="text-lg">⚠️</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">أدوية منخفضة المخزون</p>
                                <p class="text-sm text-gray-500">{{ $lowStockMedications }} أدوية تحتاج لإعادة_stock</p>
                            </div>
                        </div>
                        @endif
                        @if($expiringMedications > 0)
                        <div class="flex items-center gap-3 bg-white p-4 rounded-xl">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-lg">⏰</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">أدوية تنتهي قريباً</p>
                                <p class="text-sm text-gray-500">{{ $expiringMedications }} أدوية تنتهي خلال 30 يوم</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // إعدادات عامة
        Chart.defaults.font.family = 'Cairo, sans-serif';
        Chart.defaults.plugins.legend.display = false;

        // رسم بياني للمرضى شهرياً
        new Chart(document.getElementById('patientsChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($patientsMonthly->keys()->map(function($m) { return \Carbon\Carbon::create()->month($m)->format('F'); })) !!},
                datasets: [{
                    label: 'المرضى',
                    data: {!! json_encode($patientsMonthly->values()) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // رسم بياني للمواعيد الأسبوعية
        new Chart(document.getElementById('appointmentsChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($appointmentsWeekly->keys()) !!},
                datasets: [{
                    label: 'المواعيد',
                    data: {!! json_encode($appointmentsWeekly->values()) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // رسم دائري للنظرة العامة
        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['المرضى', 'الأطباء', 'المواعيد', 'الأدوية'],
                datasets: [{
                    data: [
                        {{ $patientsCount ?? 0 }},
                        {{ $doctorsCount ?? 0 }},
                        {{ $appointmentsCount ?? 0 }},
                        {{ $medicationsCount ?? 0 }}
                    ],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                plugins: {
                    legend: { display: true, position: 'bottom' }
                }
            }
        });
    </script>
</x-app-layout>
