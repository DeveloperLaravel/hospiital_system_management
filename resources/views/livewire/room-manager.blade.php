<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section --}}
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">إدارة الغرف</h1>
                        <p class="text-sm text-gray-500 mt-1">إضافة وتعديل وحذف غرف المستشفى</p>
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

                    {{-- View Toggle --}}
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button
                            wire:click="setViewMode('grid')"
                            class="p-2 rounded-lg transition-all duration-200 {{ $viewMode === 'grid' ? 'bg-white shadow text-blue-600' : 'text-gray-500 hover:text-gray-700' }}"
                            title="عرض شبكي"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </button>
                        <button
                            wire:click="setViewMode('table')"
                            class="p-2 rounded-lg transition-all duration-200 {{ $viewMode === 'table' ? 'bg-white shadow text-blue-600' : 'text-gray-500 hover:text-gray-700' }}"
                            title="عرض جدولي"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>

                    @if($this->canCreate())
                    <button
                        wire:click="create"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">إضافة غرفة جديدة</span>
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

    {{-- Search & Filters Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="البحث برقم الغرفة..."
                        class="w-full pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400"
                    />
                </div>

                {{-- Status Filter --}}
                <select
                    wire:model.live="filterStatus"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                >
                    <option value="">كل الحالات</option>
                    <option value="available">متاحة</option>
                    <option value="occupied">مشغولة</option>
                    <option value="maintenance">صيانة</option>
                    <option value="cleaning">تنظيف</option>
                </select>

                {{-- Type Filter --}}
                <select
                    wire:model.live="filterType"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                >
                    <option value="">كل الأنواع</option>
                    @foreach($roomTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

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

    {{-- Stats Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي الغرف</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الغرف المتاحة</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['available'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الغرف المشغولة</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['occupied'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">غرف الصيانة</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $stats['maintenance'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid View --}}
    @if($viewMode === 'grid')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($rooms as $room)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                {{-- Room Header --}}
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="text-white font-bold text-lg">غرفة {{ $room->room_number }}</span>
                        @if($room->status === 'available')
                        <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">متاحة</span>
                        @elseif($room->status === 'occupied')
                        <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">مشغولة</span>
                        @elseif($room->status === 'maintenance')
                        <span class="px-2 py-1 bg-orange-500 text-white text-xs font-bold rounded-full">صيانة</span>
                        @else
                        <span class="px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">تنظيف</span>
                        @endif
                    </div>
                </div>

                {{-- Room Body --}}
                <div class="p-4">
                    <div class="space-y-3">
                        {{-- Type & Floor --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ $roomTypes[$room->type] ?? $room->type }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                <span class="text-sm text-gray-600">الطابق {{ $room->floor }}</span>
                            </div>
                        </div>

                        {{-- Beds & Price --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ $room->beds_count }} سرير</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ number_format($room->price, 2) }}</span>
                            </div>
                        </div>

                        {{-- Current Patient --}}
                        @if($room->status === 'occupied' && $room->currentPatient())
                        <div class="bg-red-50 rounded-lg p-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm text-red-700 font-medium">{{ $room->currentPatient()->name }}</span>
                        </div>
                        @endif

                        {{-- Notes --}}
                        @if($room->notes)
                        <p class="text-xs text-gray-500 border-t pt-2">{{ Str::limit($room->notes, 50) }}</p>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-4 pt-3 border-t border-gray-100 flex gap-2">
                        @if($this->canEdit($room))
                        <button
                            wire:click="edit({{ $room->id }})"
                            class="flex-1 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-1"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            تعديل
                        </button>
                        @endif

                        @if($room->status === 'available' && $this->canAdmit())
                        <button
                            wire:click="openAdmitModal({{ $room->id }})"
                            class="flex-1 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-1"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            إدخال
                        </button>
                        @endif

                        @if($room->status === 'occupied' && $this->canDischarge())
                        <button
                            wire:click="openDischargeModal({{ $room->id }})"
                            class="flex-1 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center gap-1"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            إخراج
                        </button>
                        @endif

                        @if($this->canDelete($room))
                        <button
                            wire:click="delete({{ $room->id }})"
                            onclick="confirm('هل أنت متأكد من حذف هذه الغرفة؟') || event.stopImmediatePropagation()"
                            class="py-2 px-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                            title="حذف"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            @if(!$hasPermission)
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <p class="text-red-500 text-lg font-bold">لا توجد لديك صلاحية viewing الغرف</p>
                    <p class="text-red-400 text-sm mt-1">يرجى التواصل مع المدير للحصول على الصلاحية</p>
                </div>
            </div>
            @else
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="text-gray-500 text-lg">لا توجد غرف مسجلة</p>
                    <p class="text-gray-400 text-sm mt-1">قم بإضافة غرفة جديدة للبدء</p>
                </div>
            </div>
            @endif
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($rooms->hasPages())
        <div class="mt-6 bg-white rounded-xl shadow-md border border-gray-100 px-4 py-4">
            {{ $rooms->links() }}
        </div>
        @endif
    </div>

    {{-- Table View --}}
    @else
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">رقم الغرفة</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">النوع</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">الطابق</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">الأسرة</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">السعر</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">المريض الحالي</th>
                            @canany(['rooms-edit', 'rooms-delete'])
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">التحكم</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rooms as $room)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 text-sm font-bold rounded-full">
                                    {{ $room->id }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $room->room_number }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                    {{ $roomTypes[$room->type] ?? $room->type }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="text-gray-600">{{ $room->floor }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                    {{ $room->beds_count }} سرير
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-gray-600 font-medium">{{ number_format($room->price, 2) }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($room->status === 'available')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    متاحة
                                </span>
                                @elseif($room->status === 'occupied')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    مشغولة
                                </span>
                                @elseif($room->status === 'maintenance')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                    صيانة
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    تنظيف
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 hidden lg:table-cell">
                                @if($room->currentPatient())
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $room->currentPatient()->name }}</span>
                                </div>
                                @else
                                <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @canany(['rooms-edit', 'rooms-delete'])
                                <div class="flex items-center gap-2">
                                    @if($this->canEdit($room))
                                    <button
                                        wire:click="edit({{ $room->id }})"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors duration-200"
                                        title="تعديل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($room->status === 'available' && $this->canAdmit())
                                    <button
                                        wire:click="openAdmitModal({{ $room->id }})"
                                        class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors duration-200"
                                        title="إدخال مريض"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($room->status === 'occupied' && $this->canDischarge())
                                    <button
                                        wire:click="openDischargeModal({{ $room->id }})"
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                                        title="إخراج مريض"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                    @endif

                                    @if($this->canDelete($room))
                                    <button
                                        wire:click="delete({{ $room->id }})"
                                        onclick="confirm('هل أنت متأكد من حذف هذه الغرفة؟') || event.stopImmediatePropagation()"
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                                        title="حذف"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                                @endcanany
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-16">
                                @if(!$hasPermission)
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <p class="text-red-500 text-lg font-bold">لا توجد لديك صلاحية viewing الغرف</p>
                                    <p class="text-red-400 text-sm mt-1">يرجى التواصل مع المدير للحصول على الصلاحية</p>
                                </div>
                                @else
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">لا توجد غرف مسجلة</p>
                                    <p class="text-gray-400 text-sm mt-1">قم بإضافة غرفة جديدة للبدء</p>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($rooms->hasPages())
            <div class="bg-gray-50 px-4 py-4 border-t border-gray-100">
                {{ $rooms->links() }}
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Create/Edit Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            {{ $isEditMode ? 'تعديل غرفة' : 'إضافة غرفة جديدة' }}
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
                    <div class="space-y-5">
                        {{-- Room Number --}}
                        <div>
                            <label for="room_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                رقم الغرفة <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="room_number"
                                wire:model="room_number"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="أدخل رقم الغرفة"
                            />
                            @error('room_number')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Room Type --}}
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                نوع الغرفة <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="type"
                                wire:model="type"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            >
                                @foreach($roomTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحالة <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="status"
                                wire:model="status"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            >
                                @foreach($roomStatuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Floor & Beds --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="floor" class="block text-sm font-semibold text-gray-700 mb-2">
                                    الطابق <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="floor"
                                    wire:model="floor"
                                    min="1"
                                    max="20"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                />
                                @error('floor')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="beds_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                    عدد الأسرة <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="beds_count"
                                    wire:model="beds_count"
                                    min="1"
                                    max="10"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                />
                                @error('beds_count')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                السعر
                            </label>
                            <div class="relative">
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">$</span>
                                <input
                                    type="number"
                                    id="price"
                                    wire:model="price"
                                    min="0"
                                    step="0.01"
                                    class="w-full pr-8 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="0.00"
                                />
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                ملاحظات
                            </label>
                            <textarea
                                id="notes"
                                wire:model="notes"
                                rows="3"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="أدخل ملاحظات إضافية (اختياري)"
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
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الغرفة' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Admit Patient Modal --}}
    @if($admitModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            إدخال مريض للغرفة
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
                    @if($selectedRoom)
                    <div class="bg-blue-50 rounded-xl p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">غرفة رقم</p>
                                <p class="text-lg font-bold text-gray-800">{{ $selectedRoom->room_number }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label for="patient" class="block text-sm font-semibold text-gray-700 mb-2">
                            اختيار المريض <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="patient"
                            wire:model="selectedPatient"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        >
                            <option value="">اختر المريض</option>
                            @foreach($availablePatients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
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
                        wire:click="admitPatient"
                        type="button"
                        class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        إدخال المريض
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Discharge Patient Modal --}}
    @if($dischargeModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            إخراج المريض
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
                    @if($selectedRoom)
                    <div class="bg-red-50 rounded-xl p-4 mb-4">
                        <div class="flex items-center gap-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">غرفة رقم</p>
                                <p class="text-lg font-bold text-gray-800">{{ $selectedRoom->room_number }}</p>
                            </div>
                        </div>
                        @if($selectedRoom->currentPatient())
                        <div class="flex items-center gap-3 pt-3 border-t border-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">المريض</p>
                                <p class="text-lg font-bold text-gray-800">{{ $selectedRoom->currentPatient()->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-yellow-800 text-sm">هل أنت متأكد من إخراج المريض من الغرفة؟</p>
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
                        wire:click="dischargePatient"
                        type="button"
                        class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        إخراج المريض
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

