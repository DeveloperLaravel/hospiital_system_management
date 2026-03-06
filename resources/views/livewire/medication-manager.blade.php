<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section with Glass Effect --}}
    <div class="relative bg-white/80 backdrop-blur-lg shadow-lg border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 p-4 rounded-2xl shadow-xl shadow-indigo-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            إدارة الأدوية
                        </h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            إضافة وتعديل وحذف الأدوية مع QR Code
                        </p>
                    </div>
                </div>
                <button
                    wire:click="create"
                    class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-1"
                >
                    <span class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">إضافة دواء جديد</span>
                    <span class="sm:hidden">إضافة</span>
                </button>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-300 to-transparent"></div>
    </div>

    {{-- Messages with Animation --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session()->has('success'))
            <div class="mb-4 relative overflow-hidden bg-white/80 backdrop-blur-sm border border-green-200 rounded-2xl p-4 shadow-lg shadow-green-500/10 animate-[slideIn_0.5s_ease-out]">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-500 p-2.5 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Stats Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 to-indigo-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">إجمالي الأدوية</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-green-400/10 to-emerald-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">نشط</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/10 to-amber-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">مخزون منخفض</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['low_stock'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-red-400/10 to-rose-400/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">تنتهي قريباً</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['expiring_soon'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-5">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="البحث بالاسم أو النوع أو الباركود..."
                        class="w-full pr-14 py-4 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-2xl transition-all duration-300 text-gray-700 placeholder-gray-400 font-medium shadow-inner"
                    />
                </div>
                <button
                    wire:click="clearSearch"
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

    {{-- Table Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-50 via-gray-50 to-slate-100">
                        <tr>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                    #
                                </div>
                            </th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الاسم</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden md:table-cell">النوع</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الكمية</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden lg:table-cell">السعر</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider hidden xl:table-cell">الانتهاء</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">QR</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">الحالة</th>
                            <th class="px-4 py-5 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($medications as $medication)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-200 group">
                            <td class="px-4 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-700 text-sm font-bold rounded-xl group-hover:scale-110 transition-transform duration-200">
                                    {{ $medication->id }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/30">
                                        {{ substr($medication->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $medication->name }}</p>
                                        @if($medication->barcode)
                                            <p class="text-xs text-gray-400">{{ $medication->barcode }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5 hidden md:table-cell">
                                <span class="text-gray-600">{{ $medication->type ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-5">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold {{ $medication->quantity <= $medication->min_stock ? 'bg-gradient-to-r from-red-100 to-rose-100 text-red-700' : 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700' }}">
                                    {{ $medication->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-5 hidden lg:table-cell">
                                <span class="font-semibold text-gray-700">{{ number_format($medication->price, 2) }}</span>
                            </td>
                            <td class="px-4 py-5 hidden xl:table-cell">
                                @if($medication->expiry_date)
                                    <span class="inline-flex items-center gap-1 text-sm {{ $medication->isExpiringSoon ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $medication->expiry_date->format('Y-m-d') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-5">
                                <button
                                    wire:click="showQrCode({{ $medication->id }})"
                                    class="group/btn p-2.5 bg-gradient-to-r from-cyan-100 to-blue-100 hover:from-cyan-200 hover:to-blue-200 text-cyan-600 rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-cyan-500/20"
                                    title="عرض QR Code"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </button>
                            </td>
                            <td class="px-4 py-5">
                                @if($medication->is_active)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 rounded-full text-xs font-bold">نشط</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-100 to-rose-100 text-red-700 rounded-full text-xs font-bold">غير نشط</span>
                                @endif
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="edit({{ $medication->id }})"
                                        class="group/btn p-2.5 bg-gradient-to-r from-yellow-100 to-amber-100 hover:from-yellow-200 hover:to-amber-200 text-yellow-600 rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-yellow-500/20"
                                        title="تعديل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        wire:click="delete({{ $medication->id }})"
                                        onclick="confirm('هل أنت متأكد من حذف هذا الدواء؟') || event.stopImmediatePropagation()"
                                        class="group/btn p-2.5 bg-gradient-to-r from-red-100 to-rose-100 hover:from-red-200 hover:to-rose-200 text-red-600 rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-red-500/20"
                                        title="حذف"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-16">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">لا توجد أدوية</p>
                                    <p class="text-gray-400 text-sm mt-1">قم بإضافة первый دواء للبدء</p>
                                    <button
                                        wire:click="create"
                                        class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        إضافة دواء الآن
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($medications->hasPages())
            <div class="bg-gradient-to-r from-slate-50 to-gray-100 px-5 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        عرض <span class="font-bold text-blue-600">{{ $medications->firstItem() }}</span> إلى <span class="font-bold text-blue-600">{{ $medications->lastItem() }}</span> من <span class="font-bold text-gray-700">{{ $medications->total() }}</span> نتيجة
                    </p>
                    {{ $medications->links() }}
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
                <div class="relative bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 px-8 py-6">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16"></div>
                    <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/10 rounded-full translate-x-12 translate-y-12"></div>

                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white" id="modal-title">
                                    {{ $isEditMode ? 'تعديل دواء' : 'إضافة دواء جديد' }}
                                </h3>
                                <p class="text-white/70 text-sm mt-1">املأ البيانات المطلوبة لإضافة الدواء</p>
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
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الدواء <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="name"
                                    wire:model="name"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                    placeholder="أدخل اسم الدواء"
                                />
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">النوع</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="type"
                                    wire:model="type"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                    placeholder="مثل: أقراص، شراب، حقن"
                                />
                            </div>
                        </div>

                        {{-- Barcode --}}
                        <div>
                            <label for="barcode" class="block text-sm font-semibold text-gray-700 mb-2">الباركود</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="barcode"
                                        wire:model="barcode"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                        placeholder="أدخل الباركود"
                                    />
                                </div>
                                <button
                                    type="button"
                                    wire:click="generateBarcode"
                                    class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl font-medium hover:from-cyan-600 hover:to-blue-600 transition-all duration-200"
                                    title="توليد باركود"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                الكمية <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    id="quantity"
                                    wire:model="quantity"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                    placeholder="أدخل الكمية"
                                />
                            </div>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Min Stock --}}
                        <div>
                            <label for="min_stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحد الأدنى <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    id="min_stock"
                                    wire:model="min_stock"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                    placeholder="أدخل الحد الأدنى"
                                />
                            </div>
                            @error('min_stock')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                السعر <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    step="0.01"
                                    id="price"
                                    wire:model="price"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                    placeholder="أدخل السعر"
                                />
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Expiry Date --}}
                        <div>
                            <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">تاريخ الانتهاء</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="date"
                                    id="expiry_date"
                                    wire:model="expiry_date"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                />
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">الوصف</label>
                            <textarea
                                id="description"
                                wire:model="description"
                                class="w-full px-4 py-3.5 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-transparent focus:border-blue-400 focus:bg-white rounded-xl transition-all duration-200 text-gray-700 font-medium shadow-inner"
                                placeholder="أدخل ملاحظات إضافية"
                                rows="3"
                            ></textarea>
                        </div>

                        {{-- Active Status --}}
                        <div class="md:col-span-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                    <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700">نشط</span>
                            </label>
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
                            class="px-8 py-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الدواء' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- QR Code Modal --}}
    @if($showQrCode)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="$set('showQrCode', false)" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white/95 backdrop-blur-xl rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="relative bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-600 px-8 py-6">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white" id="modal-title">QR Code</h3>
                                <p class="text-white/70 text-sm mt-1">امسح الكود للاستفادة</p>
                            </div>
                        </div>
                        <button wire:click="$set('showQrCode', false)" class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-8 text-center">
                    @if($qrCodeData)
                        <div class="bg-white p-4 rounded-2xl inline-block shadow-lg">
                            <img src="data:image/svg+xml;base64,{{ $qrCodeData }}" alt="QR Code" class="w-48 h-48">
                        </div>
                    @else
                        <div class="w-48 h-48 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                    @endif
                    <p class="text-gray-500 text-sm mt-4">امسح هذا الكود للحصول على معلومات الدواء</p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

