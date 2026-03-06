<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">

    {{-- Header Section --}}
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">إدارة الفواتير</h1>
                        <p class="text-sm text-gray-500 mt-1">إنشاء وتعديل ومتابعة فواتير المرضى</p>
                    </div>
                </div>
                <button
                    wire:click="create"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">إنشاء فاتورة جديدة</span>
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

    {{-- Stats Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي الفواتير</p>
                        <p class="text-xl font-bold text-gray-800">{{ $statistics['total_invoices'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">إجمالي المبلغ</p>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($statistics['total_amount'] ?? 0, 2) }} $</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">المدفوع</p>
                        <p class="text-xl font-bold text-green-600">{{ number_format($statistics['paid_amount'] ?? 0, 2) }} $</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">الغير مدفوع</p>
                        <p class="text-xl font-bold text-red-600">{{ number_format($statistics['unpaid_amount'] ?? 0, 2) }} $</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter Section --}}
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
                        placeholder="البحث برقم الفاتورة أو اسم المريض..."
                        class="w-full pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400"
                    />
                </div>

                <select
                    wire:model.live="status"
                    class="border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50"
                >
                    <option value="">كل الحالات</option>
                    <option value="paid">مدفوعة</option>
                    <option value="unpaid">غير مدفوعة</option>
                    <option value="partial">مدفوعة جزئياً</option>
                </select>

                <select
                    wire:model.live="patient_id"
                    class="border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50"
                >
                    <option value="">كل المرضى</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>

                <input
                    type="date"
                    wire:model.live="start_date"
                    class="border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50"
                    placeholder="من تاريخ"
                />

                <input
                    type="date"
                    wire:model.live="end_date"
                    class="border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50"
                    placeholder="إلى تاريخ"
                />

                <button
                    wire:click="$set('search', ''); $set('status', ''); $set('patient_id', ''); $set('start_date', ''); $set('end_date', '')"
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
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">رقم الفاتورة</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المريض</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">التاريخ</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">الاستحقاق</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المبلغ</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 text-sm font-bold rounded-full">
                                    {{ $invoice->id }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm font-bold text-gray-800">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($invoice->patient?->name ?? 'م', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $invoice->patient_name }}</p>
                                        <p class="text-xs text-gray-500 md:hidden">{{ $invoice->formatted_invoice_date }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="text-gray-600 text-sm">{{ $invoice->formatted_invoice_date }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-gray-600 text-sm">{{ $invoice->formatted_due_date }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    {{ $invoice->formatted_total }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($invoice->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        مدفوعة
                                    </span>
                                @elseif($invoice->isOverdue())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        متأخرة
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        غير مدفوعة
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    <button
                                        wire:click="showDetails({{ $invoice->id }})"
                                        class="p-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-colors duration-200"
                                        title="عرض التفاصيل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <button
                                        wire:click="edit({{ $invoice->id }})"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors duration-200"
                                        title="تعديل"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    @if($invoice->status === 'unpaid')
                                        <button
                                            wire:click="markAsPaid({{ $invoice->id }})"
                                            class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors duration-200"
                                            title="تحديد كمدفوعة"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            wire:click="markAsUnpaid({{ $invoice->id }})"
                                            class="p-2 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-lg transition-colors duration-200"
                                            title="تحديد كغير مدفوعة"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    @endif

                                    <button
                                        wire:click="delete({{ $invoice->id }})"
                                        onclick="confirm('هل أنت متأكد من حذف هذه الفاتورة؟') || event.stopImmediatePropagation()"
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">لا توجد فواتير</p>
                                    <p class="text-gray-400 text-sm mt-1">قم بإنشاء فاتورة جديدة للبدء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($invoices->hasPages())
            <div class="bg-gray-50 px-4 py-4 border-t border-gray-100">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            {{ $isEditMode ? 'تعديل فاتورة' : 'إنشاء فاتورة جديدة' }}
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Patient Selection --}}
                        <div>
                            <label for="patient_id_form" class="block text-sm font-semibold text-gray-700 mb-2">
                                المريض <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="patient_id_form"
                                wire:model="patient_id_form"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            >
                                <option value="">اختر المريض</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id_form')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Invoice Date --}}
                        <div>
                            <label for="invoice_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                تاريخ الفاتورة <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="invoice_date"
                                wire:model="invoice_date"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            />
                            @error('invoice_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Due Date --}}
                        <div>
                            <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                تاريخ الاستحقاق
                            </label>
                            <input
                                type="date"
                                id="due_date"
                                wire:model="due_date"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            />
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status_form" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحالة
                            </label>
                            <select
                                id="status_form"
                                wire:model="status_form"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            >
                                <option value="unpaid">غير مدفوعة</option>
                                <option value="paid">مدفوعة</option>
                                <option value="partial">مدفوعة جزئياً</option>
                                <option value="cancelled">ملغاة</option>
                            </select>
                        </div>

                        {{-- Notes --}}
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                ملاحظات
                            </label>
                            <textarea
                                id="notes"
                                wire:model="notes"
                                rows="2"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="ملاحظات إضافية..."
                            ></textarea>
                        </div>
                    </div>

                    {{-- Invoice Items Section --}}
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-gray-800">عناصر الفاتورة</h4>
                            <button
                                type="button"
                                wire:click="$set('showItemModal', true); $set('editing_item_id', null)"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                إضافة عنصر
                            </button>
                        </div>

                        {{-- Items Table --}}
                        @if(count($items) > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">الخدمة</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 hidden md:table-cell">الوصف</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">السعر</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">الكمية</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">الإجمالي</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">التحكم</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($items as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ $item['service'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 hidden md:table-cell">{{ $item['description'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ number_format($item['price'], 2) }} $</td>
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ $item['quantity'] }}</td>
                                        <td class="px-4 py-3 text-sm font-bold text-gray-800">{{ number_format($item['price'] * $item['quantity'], 2) }} $</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-1">
                                                <button
                                                    wire:click="editItem({{ $index }})"
                                                    class="p-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded transition-colors"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    wire:click="removeItem({{ $index }})"
                                                    class="p-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-left text-sm font-bold text-gray-800">الإجمالي الكلي:</td>
                                        <td colspan="2" class="px-4 py-3 text-right text-sm font-bold text-green-600">{{ number_format(calculateSubtotal(), 2) }} $</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-gray-500">لم يتم إضافة عناصر بعد</p>
                        </div>
                        @endif
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
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إنشاء الفاتورة' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Item Modal --}}
    @if($showItemModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeItemModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">
                            {{ $editing_item_id !== null ? 'تعديل عنصر' : 'إضافة عنصر جديد' }}
                        </h3>
                        <button wire:click="closeItemModal" class="text-white hover:bg-white/20 rounded-lg p-1 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <div class="space-y-5">
                        <div>
                            <label for="item_service" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الخدمة <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="item_service"
                                wire:model="item_service"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                placeholder="أدخل اسم الخدمة"
                            />
                            @error('item_service')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="item_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                الوصف
                            </label>
                            <textarea
                                id="item_description"
                                wire:model="item_description"
                                rows="2"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                placeholder="أدخل وصف الخدمة (اختياري)"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="item_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    السعر <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">$</span>
                                    <input
                                        type="number"
                                        id="item_price"
                                        wire:model="item_price"
                                        step="0.01"
                                        min="0"
                                        class="w-full pr-8 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                        placeholder="0.00"
                                    />
                                </div>
                                @error('item_price')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="item_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                    الكمية <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="item_quantity"
                                    wire:model="item_quantity"
                                    min="1"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    placeholder="1"
                                />
                                @error('item_quantity')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                        wire:click="closeItemModal"
                        type="button"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors duration-200"
                    >
                        إلغاء
                    </button>
                    @if($editing_item_id !== null)
                    <button
                        wire:click="updateItem"
                        type="button"
                        class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white rounded-xl font-medium transition-all duration-200"
                    >
                        حفظ التعديل
                    </button>
                    @else
                    <button
                        wire:click="addItem"
                        type="button"
                        class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all duration-200"
                    >
                        إضافة العنصر
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Details Modal --}}
    @if($showDetailsModal && $selectedInvoice)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="closeDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-white">تفاصيل الفاتورة</h3>
                            <p class="text-indigo-100 text-sm">{{ $selectedInvoice->invoice_number }}</p>
                        </div>
                        <button wire:click="closeDetailsModal" class="text-white hover:bg-white/20 rounded-lg p-1 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-6">
                    {{-- Invoice Info --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">المريض</p>
                            <p class="font-semibold text-gray-800">{{ $selectedInvoice->patient_name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">الحالة</p>
                            @if($selectedInvoice->status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">مدفوعة</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">غير مدفوعة</span>
                            @endif
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">تاريخ الفاتورة</p>
                            <p class="font-semibold text-gray-800">{{ $selectedInvoice->formatted_invoice_date }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">تاريخ الاستحقاق</p>
                            <p class="font-semibold text-gray-800">{{ $selectedInvoice->formatted_due_date }}</p>
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <h4 class="text-md font-bold text-gray-800 mb-3">عناصر الفاتورة</h4>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-4">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">الخدمة</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 hidden md:table-cell">الوصف</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">السعر</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">الكمية</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($selectedInvoice->items as $item)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-800">{{ $item->service }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-500 hidden md:table-cell">{{ $item->description ?? '-' }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-800">{{ number_format($item->price, 2) }} $</td>
                                    <td class="px-3 py-2 text-sm text-gray-800">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2 text-sm font-bold text-gray-800">{{ number_format($item->price * $item->quantity, 2) }} $</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="px-3 py-2 text-left text-sm font-bold text-gray-800">الإجمالي:</td>
                                    <td class="px-3 py-2 text-right text-sm font-bold text-green-600">{{ $selectedInvoice->formatted_total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($selectedInvoice->notes)
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <p class="text-xs text-yellow-600 mb-1">ملاحظات</p>
                        <p class="text-sm text-gray-700">{{ $selectedInvoice->notes }}</p>
                    </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                        wire:click="closeDetailsModal"
                        type="button"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors duration-200"
                    >
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

