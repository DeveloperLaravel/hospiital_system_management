<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden" dir="rtl" lang="ar">

    {{-- Animated Background Orbs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-blue-400/20 to-purple-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-br from-indigo-400/20 to-pink-500/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 w-[300px] h-[300px] bg-gradient-to-br from-cyan-400/20 to-blue-500/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
    </div>

    {{-- Header --}}
    <div class="relative bg-white/80 backdrop-blur-xl shadow-2xl border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-600 p-4 rounded-2xl shadow-xl shadow-purple-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-bounce"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 via-gray-600 to-gray-800 bg-clip-text text-transparent">إدارة الورديات</h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                            <span>جدولة وتوزيع الورديات للموظفين</span>
                        </p>
                    </div>
                </div>

                <button wire:click="create" class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-600 hover:from-indigo-600 hover:via-purple-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:shadow-purple-500/30 transition-all duration-300 transform hover:-translate-y-1">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-400 to-pink-500 rounded-xl opacity-0 group-hover:opacity-50 transition-opacity duration-300 blur-lg"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="relative">وردية جديدة</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session()->has('success'))
            <div class="bg-white/90 backdrop-blur-sm border border-green-200/50 rounded-2xl p-4 mb-4 flex items-center gap-3 shadow-lg shadow-green-500/10 animate-[slideIn_0.3s_ease-out]">
                <div class="bg-gradient-to-br from-green-400 to-emerald-500 p-2 rounded-xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-green-700 font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-white/90 backdrop-blur-sm border border-red-200/50 rounded-2xl p-4 mb-4 flex items-center gap-3 shadow-lg shadow-red-500/10 animate-[slideIn_0.3s_ease-out]">
                <div class="bg-gradient-to-br from-red-400 to-orange-500 p-2 rounded-xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-red-700 font-semibold">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- Stats Cards --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-indigo-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-slate-400 to-slate-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">إجمالي الورديات</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-blue-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">مجدولة</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['scheduled'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-yellow-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">قيد التنفيذ</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-green-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">مكتملة</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-red-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-red-400 to-rose-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">ملغية</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-gray-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-gray-400 to-slate-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">غائب</p>
                        <p class="text-2xl font-bold text-gray-600">{{ $stats['absent'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Highlight --}}
        <div class="mt-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-2xl shadow-purple-500/20 p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24 blur-3xl"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">ورديات اليوم</p>
                        <p class="text-4xl font-bold">{{ $stats['today'] }} <span class="text-xl font-normal">وردية</span></p>
                    </div>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-indigo-100 text-lg font-bold">{{ now()->locale('ar')->dayName }}</p>
                    <p class="text-indigo-200 text-sm">{{ now()->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="البحث..." class="w-full pr-12 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-700 placeholder-gray-400 font-medium" />
                </div>

                <select wire:model.live="filter_status" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                    <option value="">كل الحالات</option>
                    <option value="scheduled">مجدول</option>
                    <option value="in_progress">قيد التنفيذ</option>
                    <option value="completed">مكتمل</option>
                    <option value="cancelled">ملغي</option>
                    <option value="absent">غائب</option>
                </select>

                <select wire:model.live="filter_shift_type" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                    <option value="">كل الأنواع</option>
                    <option value="morning">صباحي</option>
                    <option value="evening">مسائي</option>
                    <option value="night">ليلي</option>
                    <option value="day_off">إجازة</option>
                    <option value="on_call">حضور طوارئ</option>
                </select>

                <select wire:model.live="filter_department" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                    <option value="">كل الأقسام</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model.live="filter_date" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" />

                <button wire:click="clearFilters" class="px-6 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    إعادة
                </button>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">اسم الوردية</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الموظف</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">التاريخ والوقت</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">النوع</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">القسم</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الحالة</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($shifts as $shift)
                        <tr class="hover:bg-indigo-50/50 transition-all duration-200 group">
                            <td class="px-4 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-600 text-white text-sm font-bold rounded-xl shadow-lg">
                                    {{ $shift->id }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $shift->shift_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $shift->start_time }} - {{ $shift->end_time }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-4">
                                    @if($shift->assigned_type === 'App\Models\Doctor' && $shift->doctor)
                                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($shift->doctor->name ?? 'ط', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $shift->doctor->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">طبيب</p>
                                    </div>
                                    @elseif($shift->assigned_type === 'App\Models\Nurse' && $shift->nurse)
                                    <div class="bg-gradient-to-br from-pink-400 to-rose-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($shift->nurse->name ?? 'م', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $shift->nurse->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">ممرض</p>
                                    </div>
                                    @else
                                    <div class="bg-gradient-to-br from-gray-400 to-slate-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        -
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($shift->date)->format('d/m/Y') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 mt-1 text-gray-500 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $shift->start_time }} - {{ $shift->end_time }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                @switch($shift->shift_type)
                                    @case('morning')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700">صباحي</span>
                                        @break
                                    @case('evening')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700">مسائي</span>
                                        @break
                                    @case('night')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700">ليلي</span>
                                        @break
                                    @case('day_off')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-700">إجازة</span>
                                        @break
                                    @case('on_call')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700">حضور طوارئ</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                <span class="text-gray-700 font-medium">{{ $shift->department->name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                @switch($shift->status)
                                    @case('scheduled')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-200">مجدول</span>
                                        @break
                                    @case('in_progress')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-700 border border-yellow-200">قيد التنفيذ</span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200">مكتمل</span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200">ملغي</span>
                                        @break
                                    @case('absent')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 border border-gray-200">غائب</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <button wire:click="edit({{ $shift->id }})" class="p-2.5 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    @if($shift->status === 'scheduled')
                                    <button wire:click="updateStatus({{ $shift->id }}, 'in_progress')" class="p-2.5 bg-gradient-to-r from-blue-400 to-indigo-500 hover:from-blue-500 hover:to-indigo-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="بدء التنفيذ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($shift->status === 'in_progress')
                                    <button wire:click="updateStatus({{ $shift->id }}, 'completed')" class="p-2.5 bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="إكمال">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if(in_array($shift->status, ['scheduled', 'in_progress']))
                                    <button wire:click="updateStatus({{ $shift->id }}, 'cancelled')" class="p-2.5 bg-gradient-to-r from-orange-400 to-red-500 hover:from-orange-500 hover:to-red-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="إلغاء">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $shift->id }})" onclick="confirm('حذف الوردية؟') || event.stopImmediatePropagation()" class="p-2.5 bg-gradient-to-r from-red-400 to-rose-600 hover:from-red-500 hover:to-rose-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-20">
                                <div class="text-center">
                                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">لا توجد ورديات</p>
                                    <p class="text-gray-400 text-sm mt-1">أضف وردية جديدة للبدء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($shifts->hasPages())
            <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100">
                {{ $shifts->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">{{ $isEditMode ? 'تعديل وردية' : 'إضافة وردية جديدة' }}</h3>
                        </div>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">اسم الوردية <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="shift_name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="مثال: وردية صباحية - قسم الطوارئ" />
                            @error('shift_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع الموظف <span class="text-red-500">*</span></label>
                            <select wire:model="assigned_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="doctor">طبيب</option>
                                <option value="nurse">ممرض</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الموظف <span class="text-red-500">*</span></label>
                            <select wire:model="assigned_to" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="">اختر الموظف</option>
                                @if($assigned_type === 'doctor')
                                    @foreach($this->doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                @else
                                    @foreach($this->nurses as $nurse)
                                        <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('assigned_to') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">القسم</label>
                            <select wire:model="department_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="">اختر القسم</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع الوردية <span class="text-red-500">*</span></label>
                            <select wire:model="shift_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="morning">صباحي</option>
                                <option value="evening">مسائي</option>
                                <option value="night">ليلي</option>
                                <option value="day_off">إجازة</option>
                                <option value="on_call">حضور طوارئ</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">التاريخ <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" />
                            @error('date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">وقت البداية <span class="text-red-500">*</span></label>
                            <input type="time" wire:model="start_time" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" />
                            @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">وقت النهاية <span class="text-red-500">*</span></label>
                            <input type="time" wire:model="end_time" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" />
                            @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الحالة</label>
                            <select wire:model="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="scheduled">مجدول</option>
                                <option value="in_progress">قيد التنفيذ</option>
                                <option value="completed">مكتمل</option>
                                <option value="cancelled">ملغي</option>
                                <option value="absent">غائب</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
                            <textarea wire:model="notes" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="ملاحظات إضافية..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" type="button" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold transition-colors duration-200">إلغاء</button>
                    <button wire:click="store" type="button" class="px-6 py-3 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-600 hover:from-indigo-600 hover:via-purple-600 hover:to-pink-700 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl">
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الوردية' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .animation-delay-1000 { animation-delay: 1s; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</div>

