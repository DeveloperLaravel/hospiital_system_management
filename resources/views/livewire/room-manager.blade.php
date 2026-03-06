<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden" dir="rtl" lang="ar">

    {{-- Animated Background --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-emerald-400/20 to-teal-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-br from-cyan-400/20 to-blue-500/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
    </div>

    {{-- Header --}}
    <div class="relative bg-white/80 backdrop-blur-xl shadow-2xl border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 p-4 rounded-2xl shadow-xl shadow-emerald-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-bounce"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 via-gray-600 to-gray-800 bg-clip-text text-transparent">إدارة الغرف</h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span>ادخل واخراج المرضى من الغرف</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-1 rounded-xl flex">
                        <button wire:click="setViewMode('grid')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'grid' ? 'bg-white text-emerald-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            شبكه
                        </button>
                        <button wire:click="setViewMode('table')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'table' ? 'bg-white text-emerald-600 shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            قائمه
                        </button>
                    </div>

                    <button wire:click="create" class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:shadow-emerald-500/30 transition-all duration-300 transform hover:-translate-y-1">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-400 to-cyan-500 rounded-xl opacity-0 group-hover:opacity-50 transition-opacity duration-300 blur-lg"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="relative">غرفة جديدة</span>
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

    {{-- Stats --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-emerald-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-slate-400 to-slate-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">إجمالي الغرف</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
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
                        <p class="text-xs text-gray-500 font-medium">متاحة</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['available'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-red-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-red-400 to-rose-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">مشغولة</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['occupied'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-orange-300/50 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-orange-400 to-amber-600 p-3 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">صيانة</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $stats['maintenance'] }}</p>
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
                    <input type="text" wire:model.live="search" placeholder="البحث برقم الغرفة..." class="w-full pr-12 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-gray-700 placeholder-gray-400 font-medium" />
                </div>

                <select wire:model.live="filterStatus" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 font-medium">
                    <option value="">كل الحالات</option>
                    <option value="available">متاحة</option>
                    <option value="occupied">مشغولة</option>
                    <option value="maintenance">صيانة</option>
                    <option value="cleaning">تنظيف</option>
                </select>

                <select wire:model.live="filterType" class="px-5 py-3.5 bg-gray-50/80 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 font-medium">
                    <option value="">كل الأنواع</option>
                    <option value="single">مفردة</option>
                    <option value="double">مزدوجة</option>
                    <option value="icu">ICU</option>
                    <option value="vip">VIP</option>
                    <option value="emergency">طوارئ</option>
                </select>

                <button wire:click="clearFilters" class="px-6 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    إعادة
                </button>
            </div>
        </div>
    </div>

    {{-- Grid View --}}
    @if($viewMode === 'grid')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($rooms as $room)
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                {{-- Room Header --}}
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 p-4 relative">
                    <div class="absolute top-0 left-0 w-full h-full bg-white/10"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div class="text-white">
                                <p class="font-bold text-lg">غرفة {{ $room->room_number }}</p>
                                <p class="text-emerald-100 text-sm">{{ $roomTypes[$room->type] ?? $room->type }}</p>
                            </div>
                        </div>
                        @switch($room->status)
                            @case('available')
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-bold">متاحة</span>
                                @break
                            @case('occupied')
                                <span class="px-3 py-1 bg-red-500/80 rounded-full text-white text-xs font-bold">مشغولة</span>
                                @break
                            @case('maintenance')
                                <span class="px-3 py-1 bg-orange-500/80 rounded-full text-white text-xs font-bold">صيانة</span>
                                @break
                            @case('cleaning')
                                <span class="px-3 py-1 bg-blue-500/80 rounded-full text-white text-xs font-bold">تنظيف</span>
                                @break
                        @endswitch
                    </div>
                </div>

                {{-- Room Body --}}
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2 text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <span>الدور {{ $room->floor }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $room->beds_count }} سرير</span>
                        </div>
                    </div>

                    {{-- Current Patient --}}
                    @if($room->status === 'occupied' && $room->patients->count() > 0)
                    <div class="bg-red-50 rounded-xl p-3 mb-3">
                        <p class="text-xs text-red-500 font-medium mb-1">المريض الحالي:</p>
                        <p class="font-bold text-gray-800">{{ $room->patients->first()->name }}</p>
                    </div>
                    @else
                    <div class="bg-green-50 rounded-xl p-3 mb-3">
                        <p class="text-xs text-green-600 font-medium">الغرفة شاغرة</p>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex gap-2">
                        <button wire:click="edit({{ $room->id }})" class="flex-1 px-3 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg text-sm font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            تعديل
                        </button>

                        @if($room->status === 'available')
                        <button wire:click="openAdmitModal({{ $room->id }})" class="flex-1 px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-sm font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            إدخال
                        </button>
                        @elseif($room->status === 'occupied')
                        <button wire:click="openDischargeModal({{ $room->id }})" class="flex-1 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            إخراج
                        </button>
                        @endif

                        @if($room->status !== 'occupied')
                        <button wire:click="delete({{ $room->id }})" onclick="confirm('حذف الغرفة؟') || event.stopImmediatePropagation()" class="px-3 py-2 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg text-sm font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg font-medium">لا توجد غرف</p>
                    <p class="text-gray-400 text-sm mt-1">أضف غرفة جديدة للبدء</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($rooms->hasPages())
        <div class="mt-6 bg-white/80 backdrop-blur-lg rounded-xl px-6 py-4">
            {{ $rooms->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- Table View --}}
    @if($viewMode === 'table')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">#</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">رقم الغرفة</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">النوع</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">الدور</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">الحالة</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">المريض</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rooms as $room)
                        <tr class="hover:bg-emerald-50/50 transition-all duration-200">
                            <td class="px-4 py-5">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-600 text-white text-sm font-bold rounded-xl">
                                    {{ $room->id }}
                                </span>
                            </td>
                            <td class="px-4 py-5 font-bold text-gray-800">غرفة {{ $room->room_number }}</td>
                            <td class="px-4 py-5">
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-medium">{{ $roomTypes[$room->type] ?? $room->type }}</span>
                            </td>
                            <td class="px-4 py-5 text-gray-600">{{ $room->floor }}</td>
                            <td class="px-4 py-5">
                                @switch($room->status)
                                    @case('available')
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-green-100 text-green-700">متاحة</span>
                                        @break
                                    @case('occupied')
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-red-100 text-red-700">مشغولة</span>
                                        @break
                                    @case('maintenance')
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-orange-100 text-orange-700">صيانة</span>
                                        @break
                                    @case('cleaning')
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-100 text-blue-700">تنظيف</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-4 py-5">
                                @if($room->status === 'occupied' && $room->patients->count() > 0)
                                    <span class="font-medium text-gray-800">{{ $room->patients->first()->name }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex gap-2">
                                    <button wire:click="edit({{ $room->id }})" class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    @if($room->status === 'available')
                                    <button wire:click="openAdmitModal({{ $room->id }})" class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg" title="إدخال مريض">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </button>
                                    @elseif($room->status === 'occupied')
                                    <button wire:click="openDischargeModal({{ $room->id }})" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg" title="إخراج مريض">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($room->status !== 'occupied')
                                    <button wire:click="delete({{ $room->id }})" onclick="confirm('حذف الغرفة؟') || event.stopImmediatePropagation()" class="p-2 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg" title="حذف">
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
                            <td colspan="7" class="px-4 py-16 text-center">
                                <p class="text-gray-500">لا توجد غرف</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($rooms->hasPages())
            <div class="bg-gray-50 px-6 py-4">
                {{ $rooms->links() }}
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Add/Edit Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl transform sm:my-8 sm:align-middle sm:max-w-xl w-full">
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">{{ $isEditMode ? 'تعديل غرفة' : 'إضافة غرفة جديدة' }}</h3>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">رقم الغرفة <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="room_number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500" placeholder="101" />
                            @error('room_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">النوع <span class="text-red-500">*</span></label>
                            <select wire:model="type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500">
                                @foreach($roomTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الدور <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="floor" min="1" max="20" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">عدد الأسرة</label>
                            <input type="number" wire:model="beds_count" min="1" max="10" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الحالة</label>
                            <select wire:model="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500">
                                @foreach($roomStatuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">السعر/ليلة</label>
                            <input type="number" wire:model="price" min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500" placeholder="0" />
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
                            <textarea wire:model="notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500" placeholder="ملاحظات..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold">إلغاء</button>
                    <button wire:click="store" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl font-bold shadow-lg">
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الغرفة' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Admit Modal --}}
    @if($admitModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">إدخال مريض</h3>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6">
                    <p class="text-gray-600 mb-4">اختر المريض لإدخاله إلى الغرفة:</p>

                    <label class="block text-sm font-bold text-gray-700 mb-2">المريض</label>
                    <select wire:model="selectedPatient" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500">
                        <option value="">اختر المريض</option>
                        @foreach($availablePatients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold">إلغاء</button>
                    <button wire:click="admitPatient" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-bold shadow-lg">
                        إدخال المريض
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Discharge Modal --}}
    @if($dischargeModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">إخراج مريض</h3>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6">
                    <p class="text-gray-600 mb-4">هل أنت متأكد من إخراج المريض من الغرفة؟</p>

                    @if($selectedRoom && $selectedRoom->patients->count() > 0)
                    <div class="bg-red-50 rounded-xl p-4">
                        <p class="text-sm text-red-600">المريض:</p>
                        <p class="font-bold text-gray-800">{{ $selectedRoom->patients->first()->name }}</p>
                    </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-8 py-5 flex gap-3 justify-end">
                    <button wire:click="closeModal" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold">إلغاء</button>
                    <button wire:click="dischargePatient" class="px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white rounded-xl font-bold shadow-lg">
                        تأكيد الإخراج
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

