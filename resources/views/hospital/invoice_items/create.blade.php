<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">إضافة خدمة جديدة</h1>
                <p class="text-gray-600 mt-1">فاتورة رقم: {{ $invoice->invoice_number }}</p>
            </div>
            <a href="{{ route('invoices.items.index', $invoice) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← رجوع
            </a>
        </div>
    </div>

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('invoices.items.store', $invoice) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم الخدمة *</label>
                    <input type="text" name="service" value="{{ old('service') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="مثل: استشارة طبية - تحليل دم - أشعة">
                    @error('service')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">السعر (د.إ) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الكمية *</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                    <textarea name="description" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="تفاصيل إضافية اختيارية...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Invoice Info -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-600">المريض:</span>
                        <span class="font-medium">{{ $invoice->patient->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">المجموع الحالي:</span>
                        <span class="font-bold text-lg">{{ number_format($invoice->total, 2) }} د.إ</span>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('invoices.items.index', $invoice) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    إلغاء
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    إضافة الخدمة
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
