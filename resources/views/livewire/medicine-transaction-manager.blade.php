<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section --}}
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-3 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">إدارة المعاملات الدوائية</h1>
                        <p class="text-sm text-gray-500 mt-1">تسجيل وإدارة إدخال وإخراج الأدوية</p>
                    </div>
                </div>
                <button
                    wire:click="create"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">إضافة معاملة جديدة</span>
                    <span class="sm:hidden">إضافة</span>
                </button>
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

    {{-- Filters Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                {{-- Search --}}
                <div class="relative lg:col-span-2">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="البحث بالاسم أو المستخدم..."
                        class="w-full pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 text-gray-700 placeholder-gray-400"
                    />
                </div>

                {{-- Type Filter --}}
                <select
                    wire:model.live="type_filter"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 text-gray-700"
                >
                    <option value="">كل الأنواع</option>
                    <option value="in">إدخال</option>
                    <option value="out">إخراج</option>
                </select>

                {{-- Medication Filter --}}
                <select
                    wire:model.live="medication_filter"
                    class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 text-gray-700"
                >
                    <option value="">كل الأدوية</option>
                    @foreach($medications as $medication)
                        <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                    @endforeach
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

            {{-- Date Range --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                    <input
                        type="date"
                        wire:model.live="date_from"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 text-gray-700"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                    <input
                        type="date"
                        wire:model.live="date_to"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 text-gray-700"
                    />
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي الإدخال</p>
                        <p class="text-xl font-bold text-green-600">+{{ number_format($statistics['total_in']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي الإخراج</p>
                        <p class="text-xl font-bold text-red-600">-{{ number_format($statistics['total_out']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الرصيد</p>
                        <p class="text-xl font-bold text-blue-600">{{ number_format($statistics['balance']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-violet-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">عدد المعاملات</p>
                        <p class="text-xl font-bold text-violet-600">{{ number_format($statistics['transaction_count']) }}</p>
                    </div>
                </div>
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
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الدواء</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">النوع</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الكمية</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">المرجع</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">المستخدم</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">التاريخ</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-violet-50/50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-violet-100 text-violet-700 text-sm font-bold rounded-full">
                                    {{ $transaction->id }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-br from-violet-400 to-purple-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($transaction->medication?->name ?? 'ع', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $transaction->medication?->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">المخزون: {{ $transaction->medication?->quantity ?? 0 }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($transaction->type === 'in')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        إدخال
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                        إخراج
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="font-bold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-4 hidden md:table-cell">
                                <span class="text-gray-600 text-sm">{{ $transaction->reference_number ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 hidden lg:table-cell">
                                <span class="text-gray-600 text-sm">{{ $transaction->user?->name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-gray-600 text-sm">{{ $transaction->created_at->format('Y-m-d') }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="edit({{ $transaction->id }})"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors duration-200"
                                        title="تعديل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        wire:click="delete({{ $transaction->id }})"
                                        onclick="confirm('هل أنت متأكد من حذف هذه المعاملة؟') || event.stopImmediatePropagation()"
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                                        title="حذف"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">لا توجد معاملات مسجلة</p>
                                    <p class="text-gray-400 text-sm mt-1">قم بإضافة معاملة جديدة للبدء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions->hasPages())
            <div class="bg-gray-50 px-4 py-4 border-t border-gray-100">
                {{ $transactions->links() }}
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

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-violet-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            {{ $isEditMode ? 'تعديل معاملة' : 'إضافة معاملة جديدة' }}
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
                        {{-- Medication --}}
                        <div>
                            <label for="medication_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                الدواء <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="medication_id"
                                wire:model="medication_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200"
                            >
                                <option value="">اختر الدواء</option>
                                @foreach($medications as $medication)
                                    <option value="{{ $medication->id }}">
                                        {{ $medication->name }} (المخزون: {{ $medication->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('medication_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                نوع المعاملة <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="type" value="in" class="peer sr-only" />
                                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span class="font-medium">إدخال</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="type" value="out" class="peer sr-only" />
                                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                        <span class="font-medium">إخراج</span>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                الكمية <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="quantity"
                                wire:model="quantity"
                                min="1"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200"
                                placeholder="أدخل الكمية"
                            />
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reference Number --}}
                        <div>
                            <label for="reference_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                رقم المرجع
                            </label>
                            <input
                                type="text"
                                id="reference_number"
                                wire:model="reference_number"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200"
                                placeholder="أدخل رقم المرجع (اختياري)"
                            />
                        </div>

                        {{-- Transaction Date --}}
                        <div>
                            <label for="transaction_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                تاريخ المعاملة
                            </label>
                            <input
                                type="date"
                                id="transaction_date"
                                wire:model="transaction_date"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200"
                            />
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
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200"
                                placeholder="أدخل ملاحظات (اختياري)"
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
                        class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة المعاملة' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

