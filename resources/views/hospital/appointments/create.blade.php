<x-app-layout>
<div class="p-6" dir="rtl" lang="ar">

    <h2 class="text-2xl font-bold mb-4">
        {{ isset($appointment) ? 'تعديل موعد' : 'إضافة موعد' }}
    </h2>

    <form method="POST" action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}">
        @csrf
        @if(isset($appointment))
            @method('PUT')
        @endif

        <div class="space-y-3">

            <!-- المرضى -->
            <label class="font-semibold">المريض</label>
            @if($patients->isEmpty())
                <p class="text-gray-500 text-sm">لا يوجد مرضى. الرجاء إضافة المرضى أولاً.</p>
            @else
                <select name="patient_id" class="w-full border p-2 rounded">
                    <option value="">اختر المريض</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ (isset($appointment) && $appointment->patient_id == $patient->id) ? 'selected' : old('patient_id') }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @endif

            <!-- الأطباء -->
            <label class="font-semibold">الطبيب</label>
            @if($doctors->isEmpty())
                <p class="text-gray-500 text-sm">لا يوجد أطباء. الرجاء إضافة الأطباء أولاً.</p>
            @else
                <select name="doctor_id" class="w-full border p-2 rounded">
                    <option value="">اختر الطبيب</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ (isset($appointment) && $appointment->doctor_id == $doctor->id) ? 'selected' : old('doctor_id') }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @endif

            <!-- التاريخ والوقت -->
            <label class="font-semibold">التاريخ</label>
            <input type="date" name="date" class="w-full border p-2 rounded" value="{{ $appointment->date ?? old('date') }}">
            @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <label class="font-semibold">الوقت</label>
            <input type="time" name="time" class="w-full border p-2 rounded" value="{{ $appointment->time ?? old('time') }}">
            @error('time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <!-- الحالة -->
            <label class="font-semibold">الحالة</label>
            <select name="status" class="w-full border p-2 rounded">
                @php
                    $status = $appointment->status ?? old('status');
                @endphp
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
            </select>

        </div>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                حفظ
            </button>
            <a href="{{ route('appointments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                إلغاء
            </a>
        </div>
    </form>

</div>
</x-app-layout>
