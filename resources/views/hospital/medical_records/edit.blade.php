<x-app-layout title="تعديل سجل طبي">
    <main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-8" dir="rtl">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-file-medical text-yellow-600 ml-2"></i>
                    تعديل السجل الطبي
                </h1>
                <a href="{{ route('medical-records.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition">
                    <i class="fa-solid fa-arrow-right ml-1"></i>
                    العودة للقائمة
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl">
                <i class="fa-solid fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form action="{{ route('medical-records.update', $medical_record->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">المريض *</label>
                            <select name="patient_id" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                                <option value="">اختر المريض</option>
                                @foreach($patients as $id => $name)
                                    <option value="{{ $id }}" {{ $medical_record->patient_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الطبيب *</label>
                            <select name="doctor_id" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                                <option value="">اختر الطبيب</option>
                                @foreach($doctors as $id => $name)
                                    <option value="{{ $id }}" {{ $medical_record->doctor_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Visit Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الزيارة *</label>
                            <input type="date" name="visit_date" value="{{ old('visit_date', $medical_record->visit_date->toDateString()) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                            @error('visit_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Diagnosis -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">التشخيص</label>
                            <textarea name="diagnosis" rows="4"
                                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                placeholder="أدخل التشخيص...">{{ old('diagnosis', $medical_record->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Treatment -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">العلاج</label>
                            <textarea name="treatment" rows="4"
                                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                placeholder="أدخل العلاج...">{{ old('treatment', $medical_record->treatment) }}</textarea>
                            @error('treatment')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">ملاحظات</label>
                            <textarea name="notes" rows="3"
                                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                placeholder="ملاحظات إضافية...">{{ old('notes', $medical_record->notes) }}</textarea>
                            @error('notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('medical-records.index') }}" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 transition">
                            إلغاء
                        </a>
                        <button type="submit" class="px-6 py-3 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 shadow-lg transition">
                            <i class="fa-solid fa-save ml-1"></i>
                            تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>
