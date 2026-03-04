<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">عناصر الفاتورة</h1>
                <p class="text-gray-600 mt-1">فاتورة رقم: {{ $invoice->invoice_number }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('invoices.show', $invoice) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    ← العودة للفاتورة
                </a>
                @if($invoice->status !== 'paid')
                    <a href="{{ route('invoices.items.create', $invoice) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        + إضافة خدمة
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r">
            {{ session('error') }}
        </div>
    @endif

    <!-- Invoice Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <span class="text-gray-500 text-sm">المريض</span>
                <p class="font-medium">{{ $invoice->patient->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">تاريخ الفاتورة</span>
                <p class="font-medium">{{ $invoice->invoice_date }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">تاريخ الاستحقاق</span>
                <p class="font-medium">{{ $invoice->due_date ?? '-' }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">الحالة</span>
                <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full 
                    {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $invoice->status === 'paid' ? 'مدفوعة' : 'غير مدفوعة' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الخدمة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الوصف</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">السعر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الكمية</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">المجموع</th>
                    @if($invoice->status !== 'paid')
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الإجراءات</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($items as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->service }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->description ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                        @if($invoice->status !== 'paid')
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('invoices.items.edit', [$invoice, $item]) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('invoices.items.destroy', [$invoice, $item]) }}" 
                                          method="POST" class="inline"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $invoice->status !== 'paid' ? 7 : 6 }}" class="px-6 py-8 text-center text-gray-500">
                            لا توجد خدمات مضافة لهذه الفاتورة
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <!-- Total Row -->
            @if($items->count() > 0)
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-sm font-bold text-gray-900 text-left">
                            المجموع الكلي
                        </td>
                        <td class="px-6 py-4 text-lg font-bold text-gray-900">
                            {{ number_format($invoice->total, 2) }} د.إ
                        </td>
                        @if($invoice->status !== 'paid')
                            <td></td>
                        @endif
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <!-- Warning for paid invoices -->
    @if($invoice->status === 'paid')
        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-yellow-800">هذه الفاتورة مدفوعة ولا يمكن تعديلها.</span>
            </div>
        </div>
    @endif

</div>

</x-app-layout>
