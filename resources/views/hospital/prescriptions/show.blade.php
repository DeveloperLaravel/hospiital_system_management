<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen" dir="rtl">
        <div class="max-w-4xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">تفاصيل الوصفة الطبية</h1>
                <div class="flex gap-2">
                    <a href="{{ route('prescriptions.print', $prescription) }}" target="_blank"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        طباعة
                    </a>
                    <a href="{{ route('prescriptions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        رجوع
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
                {{--基本信息 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4">
                    <div>
                        <span class="text-gray-500">رقم الوصفة:</span>
                        <span class="font-bold mr-2">{{ $prescription->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">التاريخ:</span>
                        <span class="font-bold mr-2">{{ $prescription->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">المريض:</span>
                        <span class="font-bold mr-2">{{ $prescription->medicalRecord->patient->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">الطبيب:</span>
                        <span class="font-bold mr-2">{{ $prescription->doctor->name ?? '-' }}</span>
                    </div>
                </div>

                @if($prescription->notes)
                <div class="border-b pb-4">
                    <h3 class="text-lg font-bold mb-2">ملاحظات</h3>
                    <p class="text-gray-700">{{ $prescription->notes }}</p>
                </div>
                @endif

                {{-- قائمة الأدوية --}}
                <div>
                    <h3 class="text-lg font-bold mb-4">الأدوية</h3>
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-right border">#</th>
                                <th class="p-2 text-right border">الدواء</th>
                                <th class="p-2 text-right border">الجرعة</th>
                                <th class="p-2 text-right border">التكرار</th>
                                <th class="p-2 text-right border">المدة</th>
                                <th class="p-2 text-right border">الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescription->items as $index => $item)
                            <tr>
                                <td class="p-2 border">{{ $index + 1 }}</td>
                                <td class="p-2 border">{{ $item->medication->name ?? '-' }}</td>
                                <td class="p-2 border">{{ $item->dosage }}</td>
                                <td class="p-2 border">{{ $item->frequency }}</td>
                                <td class="p-2 border">{{ $item->duration }}</td>
                                <td class="p-2 border">{{ $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- الإجراءات --}}
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('prescriptions.edit', $prescription) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        تعديل
                    </a>
                    <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            حذف
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
