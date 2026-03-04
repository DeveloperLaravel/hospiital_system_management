<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل الفاتورة</h1>
                <p class="text-gray-600 mt-1">الفاتورة رقم: {{ $invoice->invoice_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('invoices.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
                <a href="{{ route('invoices.exportPdf', $invoice) }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    تصدير PDF
                </a>
                <a href="{{ route('invoices.edit', $invoice) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Invoice Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        معلومات الفاتورة
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Invoice Number -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">رقم الفاتورة</label>
                            <p class="text-lg font-bold text-gray-800">{{ $invoice->invoice_number }}</p>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">الحالة</label>
                            @if($invoice->status === 'paid')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-lg font-bold">مدفوعة</span>
                            @elseif($invoice->isOverdue())
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-lg font-bold">متأخرة</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-lg font-bold">غير مدفوعة</span>
                            @endif
                        </div>

                        <!-- Patient -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">المريض</label>
                            <p class="text-lg font-bold text-gray-800">{{ $invoice->patient_name }}</p>
                        </div>

                        <!-- Invoice Date -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">تاريخ الفاتورة</label>
                            <p class="text-lg font-bold text-gray-800">{{ $invoice->formatted_invoice_date }}</p>
                        </div>

                        <!-- Due Date -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">تاريخ الاستحقاق</label>
                            <p class="text-lg font-bold text-gray-800">{{ $invoice->formatted_due_date }}</p>
                        </div>

                        <!-- Total -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-blue-600 mb-1">المبلغ الإجمالي</label>
                            <p class="text-2xl font-bold text-blue-700">{{ $invoice->formatted_total }}</p>
                        </div>

                        <!-- Notes -->
                        @if($invoice->notes)
                        <div class="col-span-2 bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">ملاحظات</label>
                            <p class="text-gray-800">{{ $invoice->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Timestamps -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">تاريخ الإنشاء:</span> {{ $invoice->created_at->format('Y-m-d H:i') }}
                        </div>
                        @if($invoice->paid_at)
                        <div>
                            <span class="font-medium">تاريخ الدفع:</span> {{ $invoice->paid_at->format('Y-m-d H:i') }}
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex gap-3">
                        @if($invoice->status === 'unpaid')
                            <form method="POST" action="{{ route('invoices.markAsPaid', $invoice) }}">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    تحديد كمدفوعة
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('invoices.markAsUnpaid', $invoice) }}">
                                @csrf
                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    تحديد كغير مدفوعة
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('invoices.destroy', $invoice) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف الفاتورة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Section -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        عناصر الفاتورة
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الخدمة</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الوصف</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">السعر</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الكمية</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المجموع</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($invoice->items as $item)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $item->service }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $item->description ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($item->price, 2) }} $</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-800">{{ number_format($item->price * $item->quantity, 2) }} $</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        لا توجد عناصر
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-left text-sm font-bold text-gray-800">المجموع الكلي</td>
                                <td class="px-4 py-3 text-lg font-bold text-blue-700">{{ $invoice->formatted_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

</x-app-layout>
