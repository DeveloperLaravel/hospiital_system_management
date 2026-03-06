<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section with Glass Effect --}}
    <div class="relative bg-white/80 backdrop-blur-lg shadow-lg border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-teal-500 via-cyan-500 to-blue-600 p-4 rounded-2xl shadow-xl shadow-cyan-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">
                            إدارة عناصر الوصفات الطبية
                        </h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-cyan-400 rounded-full"></span>
                            إضافة وتعديل وحذف عناصر الوصفات الطبية
                        </p>
                    </div>
                </div>
                <button
                    wire:click="create"
                    class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-600 hover:from-teal-600 hover:via-cyan-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl shadow-cyan-500/25 transition-all duration-300 transform hover:-translate-y-1"
                >
                    <span class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">إضافة عنصر جديد</span>
                    <span class="sm:hidden">إضافة</span>
                </button>
            </div>
        </div>
        {{-- Decorative Wave --}}
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-300 to-transparent"></div>
    </div>

    {{-- Messages with Animation --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session()->has('success'))
            <div class="mb-4 relative overflow-hidden bg-white/80 backdrop-blur-sm border border-green-200 rounded-2xl p-4 shadow-lg shadow-green-500/10 animate-[slideIn_0.5s_ease-out]">
                <div class="absolute right-0 top-0 w-24 h-full bg-gradient-to-l from-green-400/10 to-transparent"></div>
                <div class="flex items-center gap-3 relative z-10">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-500 p-2.5 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="mb-4 relative overflow-hidden bg-white/80 backdrop-blur-sm border border-red-200 rounded-2xl p-4 shadow-lg shadow-red-500/10 animate-[shake_0.5s_ease-out]">
                <div class="absolute right-0 top-0 w-24 h-full bg-gradient-to-l from-red-400/10 to-transparent"></div>
                <div class="flex items-center gap-3 relative z-10">
                    <div class="bg-gradient-to-br from-red-400 to-rose-500 p-2.5 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-red-700 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Stats Cards with 3D Effect --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total --}}
            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-400/10 to-cyan-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">إجمالي العناصر</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1">
                    <span class="w-8 h-0.5 bg-gradient-to-r from-teal-400 to-cyan-400 rounded-full"></span>
                    <span class="text-xs text-gray-400">هذا النظام</span>
                </div>
            </div>

            {{-- Today --}}
            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/10 to-teal-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">اليوم</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['today'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1">
                    <span class="w-8 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full"></span>
                    <span class="text-xs text-gray-400">مواعيد اليوم</span>
                </div>
            </div>

            {{-- This Week --}}
            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 to-indigo-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">هذا الأسبوع</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['this_week'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1">
                    <span class="w-8 h-0.5 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full"></span>
                    <span class="text-xs text-gray-400">الآخر 7 أيام</span>
                </div>
            </div>

            {{-- This Month --}}
            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-400/10 to-purple-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">هذا الشهر</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['this_month'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1">
                    <span class="w-8 h-0.5 bg-gradient-to-r from-violet-400 to-purple-400 rounded-full"></span>
                    <span class="text-xs text-gray-400">آخر 30 يوم</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-5">
            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Search with Icon --}}
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <div class="w-10 h-10 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="البحث باسم المريض أو الدواء..."
                        class="w-full pr-16 py-4 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-2xl transition-all duration-300 text-gray-700 placeholder-gray-400 font-medium shadow-inner"
                    />
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap gap-3">
                    <select
                        wire:model.live="filterPrescription"
                        class="px-5 py-3 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 font-medium"
                    >
                        <option value="">كل الوصفات</option>
                        @foreach($prescriptions as $prescription)
                            <option value="{{ $prescription->id }}">#{{ $prescription->id }} - {{ $prescription->medicalRecord?->patient?->name ?? 'غير محدد' }}</option>
                        @endforeach
                    </select>

                    <select
                        wire:model.live="filterMedication"
                        class="px-5 py-3 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 font-medium"
                    >
                        <option value="">كل الأدوية</option>
                        @foreach($medications as $medication)
                            <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                        @endforeach
                    </select>

                    <input
                        type="date"
                        wire:model.live="filterDate"
                        class="px-5 py-3 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 font-medium"
                    />

                    <button
                        wire:click="clearFilters"
                        class="px-5 py-3 bg-gradient-to-br from-red-50 to-rose-100 hover:from-red-100 hover:to-rose-200 text-red-600 rounded-xl font-medium transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        إعادة
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-50 via-gray-50 to-slate-100">
                        <tr>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-teal-400 rounded-full"></span>
                                    #
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    الدواء
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    المريض
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    الجرعة
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden lg:table-cell">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    التكرار والمدة
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden lg:table-cell">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    التاريخ
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    التحكم
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                        <tr class="hover:bg-gradient-to-r hover:from-teal-50/50 hover:to-cyan-50/50 transition-all duration-200 group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-teal-100 to-cyan-100 text-teal-700 text-sm font-bold rounded-xl group-hover:scale-110 transition-transform duration-200">
                                    {{ $item->id }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 via-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-cyan-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $item->medication_name }}</p>
                                        <p class="text-xs text-gray-400">الكمية: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700">{{ $item->patient_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->doctor_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden md:table-cell">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-700">
                                    {{ $item->dosage }}
                                </span>
                            </td>
                            <td class="px-6 py-5 hidden lg:table-cell">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="text-sm">{{ $item->frequency }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm">{{ $item->formatted_duration }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden lg:table-cell">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium">{{ $item->created_at->format('Y-m-d') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="edit({{ $item->id }})"
                                        class="group/btn p-3 bg-gradient-to-r from-yellow-100 to-amber-100 hover:from-yellow-200 hover:to-amber-200 text-yellow-600 rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-yellow-500/20"
                                        title="تعديل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        wire:click="delete({{ $item->id }})"
                                        onclick="confirm('هل أنت متأكد من حذف هذا العنصر؟') || event.stopImmediatePropagation()"
                                        class="group/btn p-3 bg-gradient-to-r from-red-100 to-rose-100 hover:from-red-200 hover:to-rose-200 text-red-600 rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-red-500/20"
                                        title="حذف"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20">
                                <div class="text-center">
                                    <div class="relative inline-block">
                                        <div class="w-24 h-24 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium mt-4">لا توجد عناصر وصفات طبية</p>
                                    <p class="text-gray-400 text-sm mt-2">قم بإضافة أول عنصر لبدء التتبع</p>
                                    <button
                                        wire:click="create"
                                        class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        إضافة عنصر الآن
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($items->hasPages())
            <div class="bg-gradient-to-r from-slate-50 to-gray-100 px-6 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        عرض <span class="font-bold text-teal-600">{{ $items->firstItem() }}</span> إلى <span class="font-bold text-teal-600">{{ $items->lastItem() }}</span> من <span class="font-bold text-gray-700">{{ $items->total() }}</span> نتيجة
                    </p>
                    {{ $items->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal with Glass Effect --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white/95 backdrop-blur-xl rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                {{-- Modal Header with Gradient --}}
                <div class="relative bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-600 px-8 py-6">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16"></div>
                    <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/10 rounded-full translate-x-12 translate-y-12"></div>

                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white" id="modal-title">
                                    {{ $isEditMode ? 'تعديل عنصر وصفة طبية' : 'إضافة عنصر وصفة طبية جديدة' }}
                                </h3>
                                <p class="text-white/70 text-sm mt-1">املأ البيانات المطلوبة لإضافة العنصر</p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Prescription --}}
                        <div class="md:col-span-2">
                            <label for="prescription_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                الوصفة الطبية <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <select
                                    id="prescription_id"
                                    wire:model="prescription_id"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                >
                                    <option value="">اختر الوصفة الطبية</option>
                                    @foreach($prescriptions as $prescription)
                                        <option value="{{ $prescription->id }}">
                                            #{{ $prescription->id }} - {{ $prescription->medicalRecord?->patient?->name ?? 'غير محدد' }} - {{ $prescription->doctor?->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('prescription_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Medication --}}
                        <div class="md:col-span-2">
                            <label for="medication_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                الدواء <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <select
                                    id="medication_id"
                                    wire:model="medication_id"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                >
                                    <option value="">اختر الدواء</option>
                                    @foreach($medications as $medication)
                                        <option value="{{ $medication->id }}">{{ $medication->name }} ({{ $medication->type ?? 'غير محدد' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('medication_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dosage --}}
                        <div>
                            <label for="dosage" class="block text-sm font-semibold text-gray-700 mb-2">
                                الجرعة <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="dosage"
                                    wire:model="dosage"
                                    placeholder="مثل: 500 مج"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                />
                            </div>
                            @error('dosage')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                الكمية <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    id="quantity"
                                    wire:model="quantity"
                                    min="1"
                                    placeholder="1"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                />
                            </div>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Frequency --}}
                        <div>
                            <label for="frequency" class="block text-sm font-semibold text-gray-700 mb-2">
                                التكرار <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="frequency"
                                    wire:model="frequency"
                                    placeholder="مثل: 3 مرات يومياً"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                />
                            </div>
                            @error('frequency')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duration --}}
                        <div>
                            <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">
                                المدة <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="duration"
                                    wire:model="duration"
                                    placeholder="مثل: أسبوع واحد"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                />
                            </div>
                            @error('duration')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Instructions --}}
                        <div class="md:col-span-2">
                            <label for="instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                                تعليمات خاصة
                            </label>
                            <textarea
                                id="instructions"
                                wire:model="instructions"
                                class="w-full px-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-teal-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                placeholder="أي تعليمات خاصة للمريض..."
                                rows="3"
                            ></textarea>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gradient-to-r from-gray-50 to-slate-100 px-8 py-5 border-t border-gray-200">
                    <div class="flex items-center justify-end gap-3">
                        <button
                            wire:click="closeModal"
                            type="button"
                            class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-semibold transition-all duration-200 border-2 border-gray-200 hover:border-gray-300 shadow-sm hover:shadow-md"
                        >
                            إلغاء
                        </button>
                        <button
                            wire:click="store"
                            type="button"
                            class="px-8 py-3 bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-600 hover:from-teal-600 hover:via-cyan-600 hover:to-blue-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة العنصر' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

