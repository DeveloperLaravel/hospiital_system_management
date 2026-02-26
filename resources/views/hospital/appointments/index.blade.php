<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    {{-- رسالة النجاح --}}
    @if(session()->has('message'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Form Add / Edit --}}
        <div class="bg-white p-6 rounded-2xl shadow-md w-full lg:w-1/3">
            <h2 class="text-xl font-bold mb-4">{{ isset($appointment) ? 'تعديل موعد' : 'إضافة موعد' }}</h2>

            <form action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}" method="POST" class="space-y-4">
                @csrf
                @if(isset($appointment))
                    @method('PUT')
                @endif

                <div>
                    <label>المريض</label>
                    <select name="patient_id" class="w-full rounded-xl border px-3 py-2">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ (isset($appointment) && $appointment->patient_id == $patient->id) ? 'selected' : '' }}>{{ $patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>الطبيب</label>
                    <select name="doctor_id" class="w-full rounded-xl border px-3 py-2">
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ (isset($appointment) && $appointment->doctor_id == $doctor->id) ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>التاريخ</label>
                    <input type="date" name="date" value="{{ $appointment->date ?? '' }}" class="w-full rounded-xl border px-3 py-2">
                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>الوقت</label>
                    <input type="time" name="time" value="{{ $appointment->time ?? '' }}" class="w-full rounded-xl border px-3 py-2">
                    @error('time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>الحالة</label>
                    <select name="status" class="w-full rounded-xl border px-3 py-2">
                        @php $statuses = ['pending'=>'قيد الانتظار','confirmed'=>'مؤكد','completed'=>'مكتمل','cancelled'=>'ملغي']; @endphp
                        @foreach($statuses as $key=>$label)
                            <option value="{{ $key }}" {{ (isset($appointment) && $appointment->status == $key) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl shadow hover:bg-blue-700 transition">
                    {{ isset($appointment) ? 'تحديث الموعد' : 'إضافة موعد' }}
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="flex-1 bg-white p-6 rounded-2xl shadow-md overflow-x-auto">

            <form method="GET">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="بحث باسم المريض..."
                       class="w-full mb-4 rounded-xl border px-3 py-2">
            </form>

            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-3">المريض</th>
                        <th class="p-3">الطبيب</th>
                        <th class="p-3">التاريخ</th>
                        <th class="p-3">الوقت</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($appointments as $app)
                    <tr>
                        <td class="p-3">{{ $app->patient->name }}</td>
                        <td class="p-3">{{ $app->doctor->name }}</td>
                        <td class="p-3">{{ $app->date }}</td>
                        <td class="p-3">{{ $app->time }}</td>
                        <td class="p-3">{{ $statuses[$app->status] }}</td>
                        <td class="p-3 flex justify-center gap-2">
                            <a href="{{ route('appointments.edit',$app) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">تعديل</a>
                            <form action="{{ route('appointments.destroy',$app) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-gray-400">لا توجد مواعيد</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $appointments->links() }}
            </div>

        </div>

    </div>

</x-app-layout>