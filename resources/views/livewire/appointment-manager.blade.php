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
                        <div class="bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 p-4 rounded-2xl shadow-xl shadow-indigo-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-bounce"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 via-gray-600 to-gray-800 bg-clip-text text-transparent">إدارة المواعيد</h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span>احجز وادر مواعيد المرضى بسهولة</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- User Role & Permissions Display --}}
                    <div class="hidden lg:flex items-center gap-2">
                        {{-- Role Badge --}}
                        <div class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $this->isAdmin() ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : ($this->isSupervisor() ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white' : ($this->isDoctor() ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' : ($this->isReceptionist() ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white' : 'bg-gradient-to-r from-gray-500 to-slate-500 text-white'))) }}">
                            @if($this->isAdmin())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @elseif($this->isSupervisor())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            @elseif($this->isDoctor())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            @elseif($this->isReceptionist())
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            @endif
                            {{ $this->getUserRole() }}
                        </div>
                    </div>

                    {{-- Quick Permissions Info --}}
                    <div class="hidden md:flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-lg text-xs">
                        @if($this->canViewAll())
                        <span class="w-2 h-2 bg-purple-500 rounded-full" title="يمكن عرض كل المواعيد"></span>
                        @else
                        <span class="w-2 h-2 bg-blue-400 rounded-full" title="يمكن عرض المواعيد"></span>
                        @endif

                        @if($this->canCreate())
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن إنشاء مواعيد"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن إنشاء مواعيد"></span>
                        @endif

                        @if(auth()->user()->can('appointments-edit'))
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن تعديل مواعيد"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن تعديل مواعيد"></span>
                        @endif

                        @if(auth()->user()->can('appointments-delete'))
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن حذف مواعيد"></span>
                        @else
                        <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن حذف مواعيد"></span>
                        @endif

                        @if($this->canExport())
                        <span class="w-2 h-2 bg-indigo-500 rounded-full" title="يمكن تصدير المواعيد"></span>
                        @endif
                    </div>

                    {{-- View Toggle --}}
                    <div class="bg-gray-100 p-1 rounded-xl flex">
                        <button wire:click="setViewMode('table')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'table' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            قائمة
                        </button>
                        <button wire:click="setViewMode('calendar')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'calendar' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            تقويم
                        </button>
                    </div>

                    <button wire:click="create" class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1" {{ ! $this->canCreate() ? 'disabled' : '' }}>
                        @if(!$this->canCreate())
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl opacity-0"></span>
                        @else
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl opacity-0 group-hover:opacity-50 transition-opacity duration-300 blur-lg"></span>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="relative">موعد جديد</span>
                    </button>
                </div>
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
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-blue-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-slate-400 to-slate-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">إجمالي المواعيد</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-yellow-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">قيد الانتظار</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-blue-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">مؤكد</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['confirmed'] }}</p>
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
                        <p class="text-xs text-gray-500 font-medium">مكتمل</p>
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
                        <p class="text-xs text-gray-500 font-medium">ملغي</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">مواعيد اليوم</p>
                        <p class="text-4xl font-bold">{{ $stats['today'] }} <span class="text-xl font-normal">موعد</span></p>
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
                    <input type="text" wire:model.live="search" placeholder="البحث بالمريض أو الطبيب..." class="w-full pr-12 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400 font-medium" />
                </div>

                <select wire:model.live="filterStatus" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                    <option value="">كل الحالات</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="confirmed">مؤكد</option>
                    <option value="completed">مكتمل</option>
                    <option value="cancelled">ملغي</option>
                </select>

                <select wire:model.live="filterDoctor" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                    <option value="">كل الأطباء</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model.live="filterDate" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium" />

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
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">المريض</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الطبيب</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">التاريخ والوقت</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">النوع</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الحالة</th>
                            @canany(['appointments-edit', 'appointments-delete'])
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">التحكم</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($appointments as $appointment)
                        <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                            <td class="px-4 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg">
                                    {{ $appointment->id }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($appointment->patient->name ?? 'م', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $appointment->patient->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $appointment->patient->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-purple-400 to-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ substr($appointment->doctor->name ?? 'ط', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $appointment->doctor->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $appointment->doctor->specialty ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 mt-1 text-gray-500 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 9 0 0 9 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                @switch($appointment->appointment_type ?? 'checkup')
                                    @case('checkup')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-cyan-100 text-cyan-700">فحص عام</span>
                                        @break
                                    @case('followup')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-100 text-purple-700">متابعة</span>
                                        @break
                                    @case('emergency')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700">طوارئ</span>
                                        @break
                                    @case('consultation')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700">استشارة</span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-700">فحص عام</span>
                                @endswitch
                            </td>
                            <td class="px-4 py-5 whitespace-nowrap">
                                @switch($appointment->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-700 border border-yellow-200">قيد الانتظار</span>
                                        @break
                                    @case('confirmed')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-200">مؤكد</span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200">مكتمل</span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200">ملغي</span>
                                        @break
                                    @case('no_show')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 border border-gray-200">لم يحضر</span>
                                        @break
                                @endswitch
                            </td>
                            @canany(['appointments-edit', 'appointments-delete'])
                            <td class="px-4 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    @if(in_array($appointment->status, ['pending', 'confirmed']) && $this->canEdit($appointment))
                                    <button wire:click="edit({{ $appointment->id }})" class="p-2.5 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($appointment->status == 'pending' && $this->canConfirmAppointment($appointment))
                                    <button wire:click="confirm({{ $appointment->id }})" onclick="confirm('تأكيد الموعد؟') || event.stopImmediatePropagation()" class="p-2.5 bg-gradient-to-r from-blue-400 to-indigo-500 hover:from-blue-500 hover:to-indigo-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="تأكيد">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($appointment->status == 'confirmed' && $this->canCompleteAppointment($appointment))
                                    <button wire:click="complete({{ $appointment->id }})" class="p-2.5 bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="إكمال">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if(in_array($appointment->status, ['pending', 'confirmed']) && $this->canCancelAppointment($appointment))
                                    <button wire:click="cancel({{ $appointment->id }})" onclick="confirm('إلغاء الموعد؟') || event.stopImmediatePropagation()" class="p-2.5 bg-gradient-to-r from-orange-400 to-red-500 hover:from-orange-500 hover:to-red-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="إلغاء">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($appointment->status != 'completed' && $this->canDelete($appointment))
                                    <button wire:click="delete({{ $appointment->id }})" onclick="confirm('حذف الموعد؟') || event.stopImmediatePropagation()" class="p-2.5 bg-gradient-to-r from-red-400 to-rose-600 hover:from-red-500 hover:to-rose-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                            @endcanany
                        </tr>
                        @empty
                        <tr>
                            @if(!$this->canView())
                            <td colspan="7" class="px-4 py-20">
                                <div class="text-center">
                                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <p class="text-red-500 text-lg font-bold">لا توجد لديك صلاحية viewing المواعيد</p>
                                    <p class="text-red-400 text-sm mt-1">يرجى التواصل مع المدير للحصول على الصلاحية</p>
                                </div>
                            </td>
                            @else
                            <td colspan="6" class="px-4 py-20">
                                <div class="text-center">
                                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">لا توجد مواعيد</p>
                                    <p class="text-gray-400 text-sm mt-1">أضف موعد جديد للبدء</p>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
            <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100">
                {{ $appointments->links() }}
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
                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">{{ $isEditMode ? 'تعديل موعد' : 'إضافة موعد جديد' }}</h3>
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
                            <label class="block text-sm font-bold text-gray-700 mb-2">المريض <span class="text-red-500">*</span></label>
                            <select wire:model="patient_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                                <option value="">اختر المريض</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">الطبيب <span class="text-red-500">*</span></label>
                            <select wire:model="doctor_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                                <option value="">اختر الطبيب</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty ?? 'عام' }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">التاريخ <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium" />
                            @error('date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الوقت <span class="text-red-500">*</span></label>
                            <input type="time" wire:model="time" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium" />
                            @error('time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع الموعد</label>
                            <select wire:model="appointment_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                                <option value="checkup">فحص عام</option>
                                <option value="followup">متابعة</option>
                                <option value="emergency">طوارئ</option>
                                <option value="consultation">استشارة</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">مدة الموعد (دقيقة)</label>
                            <select wire:model="duration" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                                <option value="15">15 دقيقة</option>
                                <option value="30">30 دقيقة</option>
                                <option value="45">45 دقيقة</option>
                                <option value="60">60 دقيقة</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">الحالة</label>
                            <select wire:model="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                                <option value="pending">قيد الانتظار</option>
                                <option value="confirmed">مؤكد</option>
                                <option value="completed">مكتمل</option>
                                <option value="cancelled">ملغي</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
                            <textarea wire:model="notes" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-medium" placeholder="ملاحظات..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="is_emergency" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500" />
                                <span class="text-sm font-medium text-gray-700">طوارئ</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" type="button" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold transition-colors duration-200">إلغاء</button>
                    <button wire:click="store" type="button" class="px-6 py-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-700 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl">
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الموعد' }}
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

