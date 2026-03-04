<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل حركة الدواء</h1>
                <p class="text-gray-600 mt-1">عرض تفاصيل حركة الدواء رقم #{{ $transaction->id }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('medicine-transactions.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
                <a href="{{ route('medicine-transactions.edit', $transaction) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Transaction Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        معلومات الحركة
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Medication -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-blue-600 mb-1">الدواء</label>
                            <p class="text-lg font-bold text-gray-800">{{ $transaction->medication_name }}</p>
                        </div>

                        <!-- Type -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">نوع الحركة</label>
                            @if($transaction->type === 'in')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-lg font-bold">إدخال</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-lg font-bold">إخراج</span>
                            @endif
                        </div>

                        <!-- Quantity -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">الكمية</label>
                            <p class="text-2xl font-bold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->formatted_quantity }}
                            </p>
                        </div>

                        <!-- User -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">المستخدم</label>
                            <p class="text-lg font-bold text-gray-800">{{ $transaction->user_name }}</p>
                        </div>

                        <!-- Date -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">التاريخ</label>
                            <p class="text-lg font-bold text-gray-800">{{ $transaction->formatted_date }}</p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">تاريخ الإنشاء:</span> {{ $transaction->created_at->format('Y-m-d H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">آخر تحديث:</span> {{ $transaction->updated_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Medication Info -->
            @if($transaction->medication)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        معلومات الدواء
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">اسم الدواء</span>
                        <p class="font-bold text-gray-800">{{ $transaction->medication->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">المخزون الحالي</span>
                        <p class="font-bold text-gray-800">{{ $transaction->medication->stock_quantity ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="font-bold text-gray-800 mb-4">إجراءات</h3>
                <div class="space-y-2">
                    <a href="{{ route('medicine-transactions.edit', $transaction) }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل
                    </a>
                    <form action="{{ route('medicine-transactions.destroy', $transaction) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('هل أنت متأكد من حذف هذه الحركة؟')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

</x-app-layout>
