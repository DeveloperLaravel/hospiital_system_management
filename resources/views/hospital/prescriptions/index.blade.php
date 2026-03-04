<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    {{-- رسائل النجاح والخطأ --}}
    @if(session()->has('message'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">الوصفات الطبية</h1>
            <a href="{{ route('prescriptions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                إضافة وصفة جديدة
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="بحث باسم الدواء..."
                   class="w-full rounded-xl border px-4 py-2">
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-right">#</th>
                        <th class="p-3 text-right">المريض</th>
                        <th class="p-3 text-right">الطبيب</th>
                        <th class="p-3 text-right">عدد الأدوية</th>
                        <th class="p-3 text-right">التاريخ</th>
                        <th class="p-3 text-right">ملاحظات</th>
                        <th class="p-3 text-right">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($prescriptions as $prescription)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">{{ $prescription->id }}</td>
                        <td class="p-3">{{ $prescription->medicalRecord->patient->name ?? '-' }}</td>
                        <td class="p-3">{{ $prescription->doctor->name ?? '-' }}</td>
                        <td class="p-3">{{ $prescription->items_count }}</td>
                        <td class="p-3">{{ $prescription->created_at->format('Y-m-d') }}</td>
                        <td class="p-3">{{ Str::limit($prescription->notes, 30) }}</td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('prescriptions.show', $prescription) }}"
                                   class="text-blue-600 hover:text-blue-800">
                                    عرض
                                </a>
                                <a href="{{ route('prescriptions.edit', $prescription) }}"
                                   class="text-yellow-600 hover:text-yellow-800">
                                    تعديل
                                </a>
                                <a href="{{ route('prescriptions.print', $prescription) }}"
                                   class="text-green-600 hover:text-green-800" target="_blank">
                                    طباعة
                                </a>
                                <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')"
                                            class="text-red-600 hover:text-red-800">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">لا توجد وصفات طبية</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $prescriptions->links() }}
        </div>

    </div>

</x-app-layout>
