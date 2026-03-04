<x-app-layout title="تفاصيل السجل الطبي">
    <main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-8" dir="rtl">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-file-medical text-blue-600 ml-2"></i>
                    تفاصيل السجل الطبي
                </h1>
                <div class="flex gap-2">
                    <a href="{{ route('medical-records.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition">
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                        العودة للقائمة
                    </a>
                    @can('medical-records-edit')
                    <a href="{{ route('medical-records.edit', $medical_record->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">
                        <i class="fa-solid fa-pen ml-1"></i>
                        تعديل
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl">
                <i class="fa-solid fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Medical Record Details -->
            <div class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
                <!-- Patient & Doctor Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-xl p-4">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">المريض</h3>
                        <p class="text-lg font-bold text-gray-800">{{ $medical_record->patient->name }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">الطبيب</h3>
                        <p class="text-lg font-bold text-gray-800">{{ $medical_record->doctor->name }}</p>
                    </div>
                </div>

                <!-- Visit Date -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">تاريخ الزيارة</h3>
                    <p class="text-lg font-bold text-gray-800">{{ $medical_record->formatted_visit_date }}</p>
                </div>

                <!-- Diagnosis -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">التشخيص</h3>
                    <div class="bg-yellow-50 rounded-xl p-4">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $medical_record->diagnosis ?? 'لا يوجد تشخيص' }}</p>
                    </div>
                </div>

                <!-- Treatment -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">العلاج</h3>
                    <div class="bg-green-50 rounded-xl p-4">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $medical_record->treatment ?? 'لا يوجد علاج' }}</p>
                    </div>
                </div>

                <!-- Notes -->
                @if($medical_record->notes)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">ملاحظات</h3>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $medical_record->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Prescriptions -->
                @if($medical_record->prescriptions->count() > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">الوصفات الطبية</h3>
                    <div class="bg-purple-50 rounded-xl p-4">
                        <ul class="space-y-2">
                            @foreach($medical_record->prescriptions as $prescription)
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-prescription text-purple-600"></i>
                                <span>{{ $prescription->medication->name ?? 'غير محدد' }}</span>
                                <span class="text-gray-500">({{ $prescription->dosage }})</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Delete Form -->
                @can('medical-records-delete')
                <div class="border-t pt-6">
                    <form action="{{ route('medical-records.destroy', $medical_record->id) }}" method="POST"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل الطبي؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
                            <i class="fa-solid fa-trash ml-1"></i>
                            حذف السجل الطبي
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        </div>
    </main>
</x-app-layout>
