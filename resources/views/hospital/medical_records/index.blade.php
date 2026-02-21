<x-app-layout title="السجل الطبي">

<main class="p-4 md:p-6 lg:p-8 bg-gray-50 min-h-screen text-right" dir="rtl">

    <!-- العنوان -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h2 class="text-2xl font-bold text-gray-800">
            🏥 إدارة السجلات الطبية
        </h2>
    </div>

    <!-- رسالة نجاح -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 mb-6 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- عرض الأخطاء -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
            <ul class="list-disc pr-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- نموذج الإضافة -->
    @can('medical-records-create')
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            ➕ إضافة سجل طبي جديد
        </h3>

        <form method="POST" action="{{ route('medical_records.store') }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            <!-- المريض -->
            <div>
                <label class="block font-semibold mb-1">المريض</label>
                <select name="patient_id"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    <option value="">اختر المريض</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}"
                        {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- الطبيب -->
            <div>
                <label class="block font-semibold mb-1">الطبيب</label>
                <select name="doctor_id"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    <option value="">اختر الطبيب</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- التشخيص -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">التشخيص</label>
                <textarea name="diagnosis"
                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                          rows="3"
                          placeholder="اكتب التشخيص...">{{ old('diagnosis') }}</textarea>
            </div>

            <!-- العلاج -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">العلاج</label>
                <textarea name="treatment"
                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                          rows="3"
                          placeholder="اكتب العلاج...">{{ old('treatment') }}</textarea>
            </div>

            <!-- الملاحظات -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">ملاحظات</label>
                <textarea name="notes"
                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                          rows="2"
                          placeholder="ملاحظات إضافية...">{{ old('notes') }}</textarea>
            </div>

            <!-- زر الحفظ -->
            <div class="md:col-span-2 text-left">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded-xl shadow-md">
                    💾 حفظ السجل
                </button>
            </div>

        </form>
    </div>
    @endcan


    <!-- جدول السجلات -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm md:text-base">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4">المريض</th>
                        <th class="p-4">الطبيب</th>
                        <th class="p-4">التشخيص</th>
                        <th class="p-4 text-center">العمليات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-4 font-medium">
                                {{ $record->patient?->name ?? '-' }}
                            </td>
                            <td class="p-4">
                                {{ $record->doctor?->name ?? '-' }}
                            </td>
                            <td class="p-4 text-gray-600">
                                {{ Str::limit($record->diagnosis, 60) }}
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">

                                    @can('medical-records-delete')
                                    <form method="POST"
                                          action="{{ route('medical_records.destroy',$record) }}"
                                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-500 hover:bg-red-600 transition text-white px-3 py-1 rounded-lg shadow">
                                            🗑 حذف
                                        </button>
                                    </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-6 text-gray-500">
                                لا توجد سجلات طبية حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</main>
</x-app-layout>
