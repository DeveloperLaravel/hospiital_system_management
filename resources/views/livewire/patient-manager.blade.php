<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section --}}
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-3 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">إدارة المرضى</h1>
                        <p class="text-sm text-gray-500 mt-1">إضافة وتعديل وحذف المرضى</p>
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
                          {{-- Quick Permissions Indicators --}}
                        <div class="hidden md:flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-lg text-xs">
                            @if($this->canCreate())
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن إنشاء مريض"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن إنشاء مريض"></span>
                            @endif

                            @if(auth()->user()->can('patients-edit'))
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن تعديل مريض"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن تعديل مريض"></span>
                            @endif

                            @if(auth()->user()->can('patients-delete'))
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن حذف مريض"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن حذف مريض"></span>
                            @endif
                        </div>
                         </div>
                @if(isset($hasPermission) && $hasPermission && $this->canCreate())
                    <button
                        wire:click="create"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="hidden sm:inline">إضافة مريض جديد</span>
                        <span class="sm:hidden">إضافة</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
 </div>
    {{-- Messages --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session()->has('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-pulse">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-green-700 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-pulse">
                <div class="bg-red-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-red-700 font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- Stats Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي المرضى</p>
                        <p class="text-xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الذكور</p>
                        <p class="text-xl font-bold text-gray-800">{{ $stats['male'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-pink-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الإناث</p>
                        <p class="text-xl font-bold text-gray-800">{{ $stats['female'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">لديهم رصيد</p>
                        <p class="text-xl font-bold text-gray-800">{{ $stats['with_balance'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial Stats --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">إجمالي الرصيد المستحق</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_balance'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">إجمالي المدفوع</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_paid'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
            <div class="flex flex-col lg:flex-row gap-3">
                {{-- Search --}}
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="البحث بالاسم أو رقم الهاتف أو الهوية..."
                        class="w-full pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-gray-700 placeholder-gray-400"
                    />
                </div>

                {{-- Gender Filter --}}
                <select
                    wire:model.live="filterGender"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                >
                    <option value="">كل الجنسين</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>

                {{-- Blood Type Filter --}}
                <select
                    wire:model.live="filterBloodType"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                >
                    <option value="">كل فصائل الدم</option>
                    @foreach($bloodTypes as $blood)
                        <option value="{{ $blood }}">{{ $blood }}</option>
                    @endforeach
                </select>

                {{-- Balance Status Filter --}}
                <select
                    wire:model.live="filterBalanceStatus"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                >
                    <option value="">كل الحالات</option>
                    <option value="with_balance">لديهم رصيد</option>
                    <option value="overdue">متأخرين</option>
                    <option value="no_limit">بدون حد ائتماني</option>
                </select>

                {{-- Clear Filters --}}
                <button
                    wire:click="clearFilters"
                    class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    إعادة
                </button>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">الهوية</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">العمر</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الجنس</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">الهاتف</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">فصيلة الدم</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider bg-yellow-50">الرصيد</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($patients as $patient)
                        <tr class="hover:bg-emerald-50/50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-full">
                                    {{ $patient->id }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $patient->name }}</p>
                                        <p class="text-xs text-gray-500 md:hidden">{{ $patient->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ $patient->national_id ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-gray-700">{{ $patient->age ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($patient->gender == 'male')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">ذكر</span>
                                @elseif($patient->gender == 'female')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-700">أنثى</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="text-gray-600">{{ $patient->phone ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($patient->blood_type)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ $patient->blood_type }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap bg-yellow-50">
                                <span class="font-bold {{ $patient->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ number_format($patient->balance ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if($this->canEdit())
                                        <button
                                            wire:click="edit({{ $patient->id }})"
                                            class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors duration-200"
                                            title="تعديل"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    @endif
                                    @if($this->canDelete())
                                        <button
                                            wire:click="delete({{ $patient->id }})"
                                            onclick="confirm('هل أنت متأكد من حذف هذا المريض؟') || event.stopImmediatePropagation()"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                                            title="حذف"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-16">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">لا يوجد مرضى مسجلون</p>
                                    <p class="text-gray-400 text-sm mt-1">قم بإضافة مريض جديد للبدء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($patients->hasPages())
            <div class="bg-gray-50 px-4 py-4 border-t border-gray-100">
                {{ $patients->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            {{ $isEditMode ? 'تعديل مريض' : 'إضافة مريض جديد' }}
                        </h3>
                        <button wire:click="closeModal" class="text-white hover:bg-white/20 rounded-lg p-1 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم المريض <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="أدخل اسم المريض"
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- National ID --}}
                        <div>
                            <label for="national_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                رقم الهوية
                            </label>
                            <input
                                type="text"
                                id="national_id"
                                wire:model="national_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="أدخل رقم الهوية"
                            />
                        </div>

                        {{-- Age --}}
                        <div>
                            <label for="age" class="block text-sm font-semibold text-gray-700 mb-2">
                                العمر
                            </label>
                            <input
                                type="number"
                                id="age"
                                wire:model="age"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="أدخل العمر"
                                min="0"
                                max="150"
                            />
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                الجنس
                            </label>
                            <select
                                id="gender"
                                wire:model="gender"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                            >
                                <option value="">اختر الجنس</option>
                                <option value="male">ذكر</option>
                                <option value="female">أنثى</option>
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                الهاتف
                            </label>
                            <input
                                type="text"
                                id="phone"
                                wire:model="phone"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="أدخل رقم الهاتف"
                            />
                        </div>

                        {{-- Blood Type --}}
                        <div>
                            <label for="blood_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                فصيلة الدم
                            </label>
                            <select
                                id="blood_type"
                                wire:model="blood_type"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                            >
                                <option value="">اختر فصيلة الدم</option>
                                @foreach($bloodTypes as $blood)
                                    <option value="{{ $blood }}">{{ $blood }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Credit Limit --}}
                        <div>
                            <label for="credit_limit" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحد الائتماني
                            </label>
                            <input
                                type="number"
                                id="credit_limit"
                                wire:model="credit_limit"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                            />
                        </div>

                        {{-- Balance --}}
                        <div>
                            <label for="balance" class="block text-sm font-semibold text-gray-700 mb-2">
                                الرصيد المستحق
                            </label>
                            <input
                                type="number"
                                id="balance"
                                wire:model="balance"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                            />
                        </div>

                        {{-- Total Paid --}}
                        <div>
                            <label for="total_paid" class="block text-sm font-semibold text-gray-700 mb-2">
                                المدفوع
                            </label>
                            <input
                                type="number"
                                id="total_paid"
                                wire:model="total_paid"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                            />
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                العنوان
                            </label>
                            <textarea
                                id="address"
                                wire:model="address"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                placeholder="أدخل العنوان"
                                rows="2"
                            ></textarea>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                        wire:click="closeModal"
                        type="button"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors duration-200"
                    >
                        إلغاء
                    </button>
                    <button
                        wire:click="store"
                        type="button"
                        class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة المريض' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
