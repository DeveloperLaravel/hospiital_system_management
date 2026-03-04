<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">إضافة دواء جديد</h1>
            <a href="{{ route('medications.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl hover:bg-gray-600 transition">
                رجوع
            </a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md">
            <form action="{{ route('medications.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">اسم الدواء <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">النوع</label>
                        <input type="text" name="type" value="{{ old('type') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2" placeholder="مثل: أقراص، شراب، حقن">
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الوصف</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">الكمية <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">الحد الأدنى للمخزون <span class="text-red-500">*</span></label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                        @error('min_stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">السعر <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">تاريخ الانتهاء</label>
                        <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                        @error('expiry_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">الباركود</label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                        @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">الحالة</label>
                        <select name="is_active" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('medications.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        إلغاء
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                        إضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
