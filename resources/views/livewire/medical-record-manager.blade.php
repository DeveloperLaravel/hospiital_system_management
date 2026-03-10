<div class="min-h-screen bg-gradient-to-br from-rose-50 via-orange-50 to-amber-100 relative overflow-hidden" dir="rtl" lang="ar">

    {{-- Animated Background --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-rose-400/20 to-orange-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-br from-amber-400/20 to-red-500/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
    </div>

    {{-- Header --}}
    <div class="relative bg-white/80 backdrop-blur-xl shadow-2xl border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-rose-500 via-red-500 to-orange-600 p-4 rounded-2xl shadow-xl shadow-rose-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-red-400 rounded-full border-2 border-white animate-bounce"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 via-gray-600 to-gray-800 bg-clip-text text-transparent">السجلات الطبية</h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                            <span>سجل وادِر الحالات الطبية للمرضى</span>
                        </p>
                    </div>
                </div>
           <div class="flex items-center gap-3">
                    {{-- User Role Badge --}}
                    <div class="hidden lg:flex items-center gap-2">
                        <div class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $this->isAdmin() ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : ($this->isSupervisor() ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white' : 'bg-gradient-to-r from-gray-500 to-slate-500 text-white') }}">
                            @if($this->isAdmin())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @elseif($this->isSupervisor())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            @endif
                            {{ $this->getUserRole() }}
                        </div>
                    </div>

                    {{-- Quick Permissions Indicators --}}
                    <div class="hidden md:flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-lg text-xs">
                        @if($this->canCreate())
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن إنشاء غرف"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن إنشاء غرف"></span>
                        @endif

                        @if(auth()->user()->can('rooms-edit'))
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن تعديل غرف"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن تعديل غرف"></span>
                        @endif

                        @if(auth()->user()->can('rooms-delete'))
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن حذف غرف"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن حذف غرف"></span>
                        @endif
                    </div>
                <div class="flex items-center gap-3">
                    @if($hasPermission)
                    <div class="bg-gray-100 p-1 rounded-xl flex">
                        <button wire:click="setViewMode('table')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'table' ? 'bg-white text-rose-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            قائمه
                        </button>
                        <button wire:click="setViewMode('timeline')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'timeline' ? 'bg-white text-rose-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                            خط زمني
                        </button>
                    </div>

                    @can('medical-records-create')
                    <button wire:click="create" class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-rose-500 via-red-500 to-orange-600 hover:from-rose-600 hover:via-red-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:shadow-rose-500/30 transition-all duration-300 transform hover:-translate-y-1">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-rose-400 to-orange-500 rounded-xl opacity-0 group-hover:opacity-50 transition-opacity duration-300 blur-lg"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="relative">سجل جديد</span>
                    </button>
                    @endcan
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(!isset($hasPermission) || $hasPermission)
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
        @endif

        @if(isset($hasPermission) && !$hasPermission)
            <div class="bg-white/90 backdrop-blur-sm border border-red-200/50 rounded-2xl p-6 mb-4 flex flex-col items-center gap-3 shadow-lg shadow-red-500/10">
                <div class="bg-gradient-to-br from-red-400 to-orange-500 p-3 rounded-xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-bold text-red-700">عذراً، لا تملك صلاحية الوصول</h3>
                    <p class="text-sm text-gray-600 mt-1">لا تملك صلاحية عرض السجلات الطبية. يرجى التواصل مع مدير النظام.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Stats --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-rose-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-slate-400 to-slate-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">إجمالي السجلات</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-green-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">اليوم</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['today'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-blue-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">هذا الأسبوع</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['this_week'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-purple-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-purple-400 to-indigo-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">هذا الشهر</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['this_month'] }}</p>
                    </div>
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
                    <input type="text" wire:model.live="search" placeholder="البحث بالتشخيص أو المريض..." class="w-full pr-12 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all duration-200 text-gray-700 placeholder-gray-400 font-medium" />
                </div>

                <select wire:model.live="filterPatient" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500 font-medium">
                    <option value="">كل المرضى</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="filterDoctor" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500 font-medium">
                    <option value="">كل الأطباء</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model.live="filterDateFrom" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500 font-medium" placeholder="من" />
                <input type="date" wire:model.live="filterDateTo" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500 font-medium" placeholder="إلى" />

                <button wire:click="clearFilters" class="px-6 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    إعادة
                </button>
            </div>
        </div>
    </div>

    {{-- Table View --}}
    @if($viewMode === 'table')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">#</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">المريض</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">الطبيب</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">التاريخ</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">التشخيص</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($records as $record)
                        <tr class="hover:bg-rose-50/50 transition-all duration-200 group">
                            <td class="px-4 py-5">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-rose-400 to-red-600 text-white text-sm font-bold rounded-xl">
                                    {{ $record->id }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($record->patient->name ?? 'م', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $record->patient->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $record->patient->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($record->doctor->name ?? 'ط', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $record->doctor->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $record->doctor->specialty ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-rose-50 text-rose-700 rounded-lg text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($record->visit_date)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <p class="text-sm text-gray-700 max-w-xs truncate">{{ $record->diagnosis }}</p>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex gap-2">
                                    @can('medical-records-edit')
                                    <button wire:click="edit({{ $record->id }})" class="p-2.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-200" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @endcan
                                    @can('medical-records-delete')
                                    <button wire:click="delete({{ $record->id }})" onclick="confirm('حذف السجل الطبي؟') || event.stopImmediatePropagation()" class="p-2.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-200" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16">
                                <div class="text-center">
                                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">لا توجد سجلات طبية</p>
                                    <p class="text-gray-400 text-sm mt-1">أضف سجل طبي جديد للبدء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($records->hasPages())
            <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100">
                {{ $records->links() }}
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Timeline View --}}
    @if($viewMode === 'timeline')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="space-y-4">
            @forelse($records as $record)
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-start gap-6">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-400 to-red-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            {{ \Carbon\Carbon::parse($record->visit_date)->format('d') }}
                        </div>
                        <div class="w-0.5 h-16 bg-gradient-to-b from-rose-300 to-transparent mt-2"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold">
                                    {{ substr($record->patient->name ?? 'م', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $record->patient->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->doctor->name ?? '-' }} - {{ \Carbon\Carbon::parse($record->visit_date)->format('F Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @can('medical-records-edit')
                                <button wire:click="edit({{ $record->id }})" class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                @endcan
                                @can('medical-records-delete')
                                <button wire:click="delete({{ $record->id }})" onclick="confirm('حذف؟') || event.stopImmediatePropagation()" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endcan
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm font-bold text-gray-700 mb-2">التشخيص:</p>
                            <p class="text-sm text-gray-600">{{ $record->diagnosis }}</p>
                            @if($record->treatment)
                            <p class="text-sm font-bold text-gray-700 mt-3 mb-2">العلاج:</p>
                            <p class="text-sm text-gray-600">{{ $record->treatment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <p class="text-gray-500">لا توجد سجلات</p>
            </div>
            @endforelse
        </div>
        @if($records->hasPages())
        <div class="mt-6 bg-white/80 backdrop-blur-lg rounded-xl px-6 py-4">
            {{ $records->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl transform sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                <div class="bg-gradient-to-r from-rose-500 via-red-500 to-orange-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">{{ $isEditMode ? 'تعديل سجل طبي' : 'إضافة سجل طبي جديد' }}</h3>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6 max-h-[70vh] overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">المريض <span class="text-red-500">*</span></label>
                            <select wire:model="patient_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500">
                                <option value="">اختر المريض</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الطبيب <span class="text-red-500">*</span></label>
                            <select wire:model="doctor_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500">
                                <option value="">اختر الطبيب</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ الزيارة <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="visit_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" />
                            @error('visit_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الموعد</label>
                            <select wire:model="appointment_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500">
                                <option value="">اختر موعد (اختياري)</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}">{{ $appointment->patient->name ?? '' }} - {{ $appointment->date }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">الأعراض</label>
                            <textarea wire:model="symptoms" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" placeholder="أدخل الأعراض..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">التشخيص <span class="text-red-500">*</span></label>
                            <textarea wire:model="diagnosis" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" placeholder="أدخل التشخيص..."></textarea>
                            @error('diagnosis') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">العلاج</label>
                            <textarea wire:model="treatment" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" placeholder="أدخل خطة العلاج..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">العلامات الحيوية</label>
                            <input type="text" wire:model="vital_signs" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" placeholder="مثال: ضغط الدم 120/80، نبض 72..." />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
                            <textarea wire:model="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-rose-500" placeholder="ملاحظات إضافية..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold">إلغاء</button>
                    <button wire:click="store" class="px-6 py-3 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white rounded-xl font-bold shadow-lg">
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة السجل' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .animation-delay-1000 { animation-delay: 1s; }
    </style>
</div>

