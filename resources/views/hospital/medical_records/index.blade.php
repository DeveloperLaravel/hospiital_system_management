<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

        {{-- رسائل النجاح والخطأ --}}
        @if(session()->has('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- نموذج إضافة/تعديل السجل الطبي --}}
            <div class="bg-white p-6 rounded-2xl shadow-md w-full lg:w-1/3">
                <h2 class="text-xl font-bold mb-4 text-gray-800">
                    {{ isset($medical_record) ? 'تعديل السجل الطبي' : 'إضافة سجل طبي جديد' }}
                </h2>

                <form action="{{ isset($medical_record) ? route('medical-records.update', $medical_record) : route('medical-records.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @if(isset($medical_record))
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">المريض</label>
                        <select name="patient_id" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">اختر المريض</option>
                            @foreach($patients as $id => $name)
                                <option value="{{ $id }}" {{ (isset($medical_record) && $medical_record->patient_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الطبيب</label>
                        <select name="doctor_id" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">اختر الطبيب</option>
                            @foreach($doctors as $id => $name)
                                <option value="{{ $id }}" {{ (isset($medical_record) && $medical_record->doctor_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الزيارة</label>
                        <input type="date" name="visit_date" value="{{ isset($medical_record) ? $medical_record->visit_date : now()->toDateString() }}" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('visit_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">التشخيص</label>
                        <textarea name="diagnosis" rows="3" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل التشخيص...">{{ isset($medical_record) ? $medical_record->diagnosis : '' }}</textarea>
                        @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">العلاج</label>
                        <textarea name="treatment" rows="3" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل العلاج...">{{ isset($medical_record) ? $medical_record->treatment : '' }}</textarea>
                        @error('treatment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ملاحظات</label>
                        <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ملاحظات إضافية...">{{ isset($medical_record) ? $medical_record->notes : '' }}</textarea>
                        @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl hover:bg-blue-700 transition duration-200 font-medium">
                        {{ isset($medical_record) ? 'تحديث السجل' : 'إضافة السجل' }}
                    </button>
                </form>
            </div>

            {{-- جدول السجلات الطبية --}}
            <div class="flex-1 bg-white p-6 rounded-2xl shadow-md overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">السجلات الطبية</h2>

                    {{-- البحث --}}
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث..."
                               class="rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                            بحث
                        </button>
                    </form>
                </div>

                <table class="min-w-full text-sm text-center">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="p-3">#</th>
                            <th class="p-3">المريض</th>
                            <th class="p-3">الطبيب</th>
                            <th class="p-3">تاريخ الزيارة</th>
                            <th class="p-3">التشخيص</th>
                            <th class="p-3">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($records as $index => $record)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 text-gray-500">{{ $records->firstItem() + $index }}</td>
                            <td class="p-3 font-medium text-gray-800">{{ $record->patient->name ?? 'غير محدد' }}</td>
                            <td class="p-3 text-gray-600">{{ $record->doctor->name ?? 'غير محدد' }}</td>
                            <td class="p-3 text-gray-600">{{ $record->visit_date ? \Carbon\Carbon::parse($record->visit_date)->format('d/m/Y') : '-' }}</td>
                            <td class="p-3 text-gray-600 max-w-xs truncate" title="{{ $record->diagnosis }}">
                                {{ Str::limit($record->diagnosis, 50) ?? '-' }}
                            </td>
                            <td class="p-3">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('medical-records.show', $record) }}"
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-xs">
                                        عرض
                                    </a>
                                    <a href="{{ route('patients.medical-history', $record->patient_id) }}"
                                       class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition text-xs">
                                        التاريخ
                                    </a>
                                    <form action="{{ route('medical-records.destroy', $record) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-xs">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-gray-400 text-center">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                لا توجد سجلات طبية
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
