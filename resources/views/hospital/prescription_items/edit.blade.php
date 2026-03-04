<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تعديل عنصر الوصفة الطبية</h1>
                <p class="text-gray-600 mt-1">تعديل بيانات عنصر في الوصفة الطبية</p>
            </div>
            <a href="{{ route('prescription-items.index') }}"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                تعديل عنصر الوصفة الطبية
            </h2>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('prescription-items.update', $item) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prescription Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الوصفة الطبية <span class="text-red-500">*</span></label>
                        <select name="prescription_id" id="prescription_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">اختر الوصفة الطبية</option>
                            @foreach($prescriptions as $p)
                                <option value="{{ $p->id }}" {{ $item->prescription_id == $p->id ? 'selected' : '' }}>
                                    وصفة #{{ $p->id }} - {{ $p->medicalRecord?->patient?->name ?? 'غير محدد' }}
                                    ({{ $p->doctor?->name ?? 'غير محدد' }})
                                </option>
                            @endforeach
                        </select>
                        @error('prescription_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medication Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الدواء <span class="text-red-500">*</span></label>
                        <select name="medication_id" id="medication_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">اختر الدواء</option>
                            @foreach($medications as $m)
                                <option value="{{ $m->id }}" {{ $item->medication_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} - المتوفر: {{ $m->stock_quantity ?? 0 }}
                                </option>
                            @endforeach
                        </select>
                        @error('medication_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dosage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الجرعة <span class="text-red-500">*</span></label>
                        <input type="text" name="dosage" id="dosage"
                               value="{{ old('dosage', $item->dosage) }}"
                               placeholder="مثال: 500mg"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('dosage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Frequency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">التكرار <span class="text-red-500">*</span></label>
                        <input type="text" name="frequency" id="frequency"
                               value="{{ old('frequency', $item->frequency) }}"
                               placeholder="مثال: 3 مرات يومياً"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('frequency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المدة (أيام) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration" id="duration"
                               min="1" value="{{ old('duration', $item->duration) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الكمية <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity"
                               min="1" value="{{ old('quantity', $item->quantity) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Instructions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تعليمات إضافية</label>
                    <textarea name="instructions" id="instructions" rows="4"
                              placeholder="تعليمات خاصة للمريض حول استخدام الدواء..."
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('instructions', $item->instructions) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('prescription-items.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">
                        إلغاء
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

</x-app-layout>
