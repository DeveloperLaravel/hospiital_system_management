<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">إنشاء فاتورة جديدة</h1>
                <p class="text-gray-600 mt-1">إضافة فاتورة جديدة لمريض</p>
            </div>
            <a href="{{ route('invoices.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
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

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                بيانات الفاتورة
            </h2>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('invoices.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المريض <span class="text-red-500">*</span></label>
                        <select name="patient_id" id="patient_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">اختر المريض</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Invoice Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الفاتورة</label>
                        <input type="date" name="invoice_date" id="invoice_date"
                               value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" id="due_date"
                               value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                        <select name="status" id="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="unpaid" selected>غير مدفوعة</option>
                            <option value="paid">مدفوعة</option>
                        </select>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="ملاحظات إضافية..."></textarea>
                </div>

                <!-- Items Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">عناصر الفاتورة</h3>

                    <div id="items-container" class="space-y-4">
                        <div class="item-row grid grid-cols-12 gap-2 items-end bg-gray-50 p-4 rounded-lg">
                            <div class="col-span-4">
                                <label class="block text-xs text-gray-500 mb-1">الخدمة <span class="text-red-500">*</span></label>
                                <input type="text" name="items[0][service]"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required placeholder="اسم الخدمة">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs text-gray-500 mb-1">الوصف</label>
                                <input type="text" name="items[0][description]"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="وصف الخدمة">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">السعر <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][price]" step="0.01" min="0"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required placeholder="0.00">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">الكمية <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][quantity]" min="1" value="1"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            <div class="col-span-1">
                                <button type="button" class="text-red-600 hover:text-red-800 p-2" onclick="this.closest('.item-row').remove()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addItem()"
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        إضافة عنصر
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('invoices.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">
                        إلغاء
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        إنشاء الفاتورة
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
let itemCount = 1;

function addItem() {
    const container = document.getElementById('items-container');
    const newItem = document.createElement('div');
    newItem.className = 'item-row grid grid-cols-12 gap-2 items-end bg-gray-50 p-4 rounded-lg';
    newItem.innerHTML = `
        <div class="col-span-4">
            <label class="block text-xs text-gray-500 mb-1">الخدمة <span class="text-red-500">*</span></label>
            <input type="text" name="items[${itemCount}][service]"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required placeholder="اسم الخدمة">
        </div>
        <div class="col-span-3">
            <label class="block text-xs text-gray-500 mb-1">الوصف</label>
            <input type="text" name="items[${itemCount}][description]"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   placeholder="وصف الخدمة">
        </div>
        <div class="col-span-2">
            <label class="block text-xs text-gray-500 mb-1">السعر <span class="text-red-500">*</span></label>
            <input type="number" name="items[${itemCount}][price]" step="0.01" min="0"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required placeholder="0.00">
        </div>
        <div class="col-span-2">
            <label class="block text-xs text-gray-500 mb-1">الكمية <span class="text-red-500">*</span></label>
            <input type="number" name="items[${itemCount}][quantity]" min="1" value="1"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>
        <div class="col-span-1">
            <button type="button" class="text-red-600 hover:text-red-800 p-2" onclick="this.closest('.item-row').remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    `;
    container.appendChild(newItem);
    itemCount++;
}
</script>

</x-app-layout>
