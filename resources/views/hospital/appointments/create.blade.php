<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6" dir="rtl" lang="ar">

    <div class="max-w-3xl mx-auto">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-l from-blue-600 to-blue-500 px-6 py-5">
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                    {{ isset($appointment) ? 'تعديل موعد' : 'إضافة موعد جديد' }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">
                    قم بإدخال بيانات الموعد بشكل صحيح
                </p>
            </div>

            {{-- Form --}}
            <div class="p-6 sm:p-8">

                <form method="POST"
                      action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}"
                      class="space-y-6">
                    @csrf
                    @if(isset($appointment))
                        @method('PUT')
                    @endif

                    {{-- المرضى + الأطباء --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- المريض --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                المريض
                            </label>

                            @if($patients->isEmpty())
                                <p class="text-gray-400 text-sm">لا يوجد مرضى</p>
                            @else
                                <select name="patient_id"
                                        class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">اختر المريض</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ (isset($appointment) && $appointment->patient_id == $patient->id) ? 'selected' : (old('patient_id') == $patient->id ? 'selected' : '') }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        {{-- الطبيب --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                الطبيب
                            </label>

                            @if($doctors->isEmpty())
                                <p class="text-gray-400 text-sm">لا يوجد أطباء</p>
                            @else
                                <select name="doctor_id"
                                        class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">اختر الطبيب</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ (isset($appointment) && $appointment->doctor_id == $doctor->id) ? 'selected' : (old('doctor_id') == $doctor->id ? 'selected' : '') }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                    </div>

                    {{-- التاريخ + الوقت --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                التاريخ
                            </label>
                            <input type="date"
                                   name="date"
                                   value="{{ $appointment->date ?? old('date') }}"
                                   class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                الوقت
                            </label>
                            <input type="time"
                                   name="time"
                                   value="{{ $appointment->time ?? old('time') }}"
                                   class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- الحالة --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            الحالة
                        </label>

                        @php
                            $status = $appointment->status ?? old('status') ?? 'pending';
                        @endphp

                        <select name="status"
                                class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                            <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">

                        <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
                            حفظ الموعد
                        </button>

                        <a href="{{ route('appointments.index') }}"
                           class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition text-center">
                            إلغاء
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
</x-app-layout>
