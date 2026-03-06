<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">
    <!-- Loading State -->
    <div wire:loading class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 shadow-2xl flex flex-col items-center gap-4">
            <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-500 border-t-transparent"></div>
            <p class="text-gray-700 font-medium">جاري تحميل البيانات...</p>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        لوحة تحكم المستشفى 🏥
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        مرحباً بك! إليك ملخص شامل لجميع إحصائيات المستشفى
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Date Range Selector -->
                    <div class="flex bg-white rounded-xl shadow-sm border border-gray-200 p-1">
                        <button wire:click="setDateRange('today')"
                            class="px-4 py-2 text-sm rounded-lg transition-all {{ $dateRange === 'today' ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            اليوم
                        </button>
                        <button wire:click="setDateRange('week')"
                            class="px-4 py-2 text-sm rounded-lg transition-all {{ $dateRange === 'week' ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            الأسبوع
                        </button>
                        <button wire:click="setDateRange('month')"
                            class="px-4 py-2 text-sm rounded-lg transition-all {{ $dateRange === 'month' ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            الشهر
                        </button>
                    </div>

                    <!-- Refresh Button -->
                    <button wire:click="refreshData"
                        class="p-2 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-600 hover:text-blue-500 hover:border-blue-300 transition-all"
                        title="تحديث البيانات">
                        <svg class="w-5 h-5 {{ $refreshInterval ? 'animate-spin-slow' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>

                    <!-- Auto Refresh Indicator -->
                    <div class="flex items-center gap-2 text-sm text-gray-500 bg-white px-3 py-2 rounded-xl shadow-sm border border-gray-200">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        تحديث تلقائي كل {{ $refreshInterval }}ث
                    </div>

                    <!-- Current Date -->
                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ now()->locale('ar')->format('l j F Y') }}
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 1 -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Patients -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">المرضى</p>
                            <p class="text-3xl font-bold mt-1">{{ $basicStats['patients'] ?? 0 }}</p>
                            <p class="text-blue-100 text-xs mt-1">جديد: {{ $activityStats['newPatientsThisWeek'] ?? 0 }} هذا الأسبوع</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-blue-100">
                        <span>{{ $activityStats['newPatientsThisMonth'] ?? 0 }} هذا الشهر</span>
                        <a href="{{ route('patients.index') }}" class="hover:text-white">عرض الكل →</a>
                    </div>
                </div>

                <!-- Doctors -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm">الأطباء</p>
                            <p class="text-3xl font-bold mt-1">{{ $basicStats['doctors'] ?? 0 }}</p>
                            <p class="text-emerald-100 text-xs mt-1">مؤكد: {{ $appointmentsStats['thisWeek'] ?? 0 }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🩺</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-emerald-100">
                        <span>{{ $appointmentsStats['thisMonth'] ?? 0 }} موعد هذا الشهر</span>
                        <a href="{{ route('doctors.index') }}" class="hover:text-white">عرض الكل →</a>
                    </div>
                </div>

                <!-- Appointments -->
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm">المواعيد</p>
                            <p class="text-3xl font-bold mt-1">{{ $basicStats['appointments'] ?? 0 }}</p>
                            <p class="text-amber-100 text-xs mt-1">اليوم: {{ $appointmentsStats['today'] ?? 0 }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-amber-100">
                        <span>{{ $appointmentsStats['tomorrow'] ?? 0 }} غداً</span>
                        <a href="{{ route('appointments.index') }}" class="hover:text-white">عرض الكل →</a>
                    </div>
                </div>

                <!-- Rooms -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">الغرف</p>
                            <p class="text-3xl font-bold mt-1">{{ $roomsStats['total'] ?? 0 }}</p>
                            <p class="text-purple-100 text-xs mt-1">مشغولة: {{ $roomsStats['occupied'] ?? 0 }} ({{ $roomsStats['occupancyRate'] ?? 0 }}%)</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🏨</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-purple-100">
                        <span>{{ $roomsStats['available'] ?? 0 }} متاحة</span>
                        <a href="{{ route('rooms.index') }}" class="hover:text-white">عرض الكل →</a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 2 -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Medications -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الأدوية</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $basicStats['medications'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">💊</span>
                        </div>
                    </div>
                    @if(($medicationsStats['lowStock'] ?? 0) > 0)
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            {{ $medicationsStats['lowStock'] }} منخفض المخزون
                        </p>
                    @else
                        <p class="text-green-500 text-xs mt-2 flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            مخزون طبيعي
                        </p>
                    @endif
                    <a href="{{ route('medications.index') }}" class="text-blue-600 text-xs mt-2 block hover:underline">عرض الكل →</a>
                </div>

                <!-- Prescriptions -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الوصفات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $basicStats['prescriptions'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">📋</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ $activityStats['prescriptionsThisMonth'] ?? 0 }} هذا الشهر</p>
                    <a href="{{ route('prescriptions.index') }}" class="text-blue-600 text-xs mt-2 block hover:underline">عرض الكل →</a>
                </div>

                <!-- Medical Records -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">السجلات الطبية</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $basicStats['medicalRecords'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">📁</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ $activityStats['medicalRecordsThisMonth'] ?? 0 }} هذا الشهر</p>
                    <a href="{{ route('medical-records.index') }}" class="text-blue-600 text-xs mt-2 block hover:underline">عرض الكل →</a>
                </div>

                <!-- Revenue -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الإيرادات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($financialStats['totalRevenue'] ?? 0, 0) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">💰</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">{{ number_format($financialStats['revenueThisMonth'] ?? 0, 0) }} هذا الشهر</p>
                    <a href="{{ route('invoices.index') }}" class="text-blue-600 text-xs mt-2 block hover:underline">عرض الكل →</a>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                <!-- Patients Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">المرضى شهرياً</h3>
                        <button wire:click="exportData('patients')" class="text-gray-400 hover:text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                    </div>
                    <canvas id="patientsChart" height="200"></canvas>
                </div>

                <!-- Appointments Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">المواعيد الأسبوعية</h3>
                        <button wire:click="exportData('appointments')" class="text-gray-400 hover:text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                    </div>
                    <canvas id="appointmentsChart" height="200"></canvas>
                </div>

                <!-- Revenue Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">الإيرادات الشهرية</h3>
                        <button class="text-gray-400 hover:text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                    </div>
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Patients -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">آخر المرضى</h3>
                        <div class="flex items-center gap-2">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text"
                                    wire:model.live="search"
                                    placeholder="بحث..."
                                    class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <a href="{{ route('patients.index') }}" class="text-blue-600 text-sm hover:underline">عرض الكل</a>
                        </div>
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
                                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('patients.index') }}'">
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
                        <div class="flex items-center gap-2">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text"
                                    wire:model.live="search"
                                    placeholder="بحث..."
                                    class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <a href="{{ route('appointments.index') }}" class="text-blue-600 text-sm hover:underline">عرض الكل</a>
                        </div>
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
                                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('appointments.index') }}'">
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
            @if(count($alerts) > 0)
            <div class="mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        التنبيهات والمخالفات
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ count($alerts) }}</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($alerts as $alert)
                        <div class="flex items-start gap-3 bg-white p-4 rounded-xl border border-yellow-100">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                @switch($alert['type'])
                                    @case('warning') bg-yellow-100 @break
                                    @case('danger') bg-red-100 @break
                                    @case('error') bg-red-100 @break
                                    @case('info') bg-blue-100 @break
                                    @default bg-gray-100
                                @endswitch
                            ">
                                <span class="text-lg">{{ $alert['icon'] }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $alert['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $alert['message'] }}</p>
                                @if(count($alert['items']) > 0)
                                    <ul class="mt-2 text-xs text-gray-400">
                                        @foreach($alert['items'] as $item)
                                            <li>• {{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">إجراءات سريعة</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <a href="{{ route('patients.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-blue-50 transition-colors group">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <span class="text-xl">👤</span>
                        </div>
                        <span class="text-sm text-gray-600">مريض جديد</span>
                    </a>
                    <a href="{{ route('appointments.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-green-50 transition-colors group">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <span class="text-xl">📅</span>
                        </div>
                        <span class="text-sm text-gray-600">موعد جديد</span>
                    </a>
                    <a href="{{ route('prescriptions.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-purple-50 transition-colors group">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <span class="text-xl">💊</span>
                        </div>
                        <span class="text-sm text-gray-600">وصفة طبية</span>
                    </a>
                    <a href="{{ route('invoices.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-yellow-50 transition-colors group">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                            <span class="text-xl">💰</span>
                        </div>
                        <span class="text-sm text-gray-600">فاتورة</span>
                    </a>
                    <a href="{{ route('rooms.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-indigo-50 transition-colors group">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                            <span class="text-xl">🏨</span>
                        </div>
                        <span class="text-sm text-gray-600">حجز غرفة</span>
                    </a>
                    <a href="{{ route('medical-records.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-red-50 transition-colors group">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition-colors">
                            <span class="text-xl">📋</span>
                        </div>
                        <span class="text-sm text-gray-600">سجل طبي</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // إعدادات عامة
        Chart.defaults.font.family = 'Cairo, sans-serif';
        Chart.defaults.plugins.legend.display = false;

        // رسم بياني للمرضى شهرياً
        const patientsCtx = document.getElementById('patientsChart');
        if (patientsCtx) {
            new Chart(patientsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($patientsChartData['labels']) !!},
                    datasets: [{
                        label: 'المرضى',
                        data: {!! json_encode($patientsChartData['data']) !!},
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
        }

        // رسم بياني للمواعيد الأسبوعية
        const appointmentsCtx = document.getElementById('appointmentsChart');
        if (appointmentsCtx) {
            new Chart(appointmentsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($appointmentsChartData['labels']) !!},
                    datasets: [{
                        label: 'المواعيد',
                        data: {!! json_encode($appointmentsChartData['data']) !!},
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
        }

        // رسم بياني للإيرادات
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueChartData['labels']) !!},
                    datasets: [{
                        label: 'الإيرادات',
                        data: {!! json_encode($revenueChartData['data']) !!},
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#f59e0b',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Listen for refresh events
        window.addEventListener('refresh-charts', () => {
            // إعادة تحميل البيانات
            location.reload();
        });

        // Listen for export events
        window.addEventListener('export-data', (event) => {
            console.log('Export requested:', event.detail);
            // يمكن إضافة функция تصدير هنا
        });
    </script>
</div>

