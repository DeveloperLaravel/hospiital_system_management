<x-app-layout>
<div class="p-6" dir="rtl" lang="ar">

    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">إدارة المواعيد</h2>

        <div class="flex gap-3">
            <form method="GET" action="{{ route('appointments.index') }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="بحث باسم المريض..."
                       class="border px-3 py-2 rounded">
            </form>

            <a href="{{ route('appointments.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                إضافة موعد
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">المريض</th>
                    <th class="p-3">الطبيب</th>
                    <th class="p-3">التاريخ</th>
                    <th class="p-3">الوقت</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($appointments as $appointment)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $appointment->patient->name }}</td>
                    <td class="p-3">{{ $appointment->doctor->name }}</td>
                    <td class="p-3">{{ $appointment->date }}</td>
                    <td class="p-3">{{ $appointment->time }}</td>
                    <td class="p-3">
                        @if($appointment->status == 'confirmed')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">مؤكد</span>
                        @elseif($appointment->status == 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">قيد الانتظار</span>
                        @elseif($appointment->status == 'completed')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">مكتمل</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">ملغي</span>
                        @endif
                    </td>
                    <td class="p-3 flex justify-center gap-2">
                        <a href="{{ route('appointments.edit', $appointment) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                            تعديل
                        </a>

                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700"
                                    onclick="return confirm('هل أنت متأكد من حذف الموعد؟')">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-gray-500">لا توجد مواعيد</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $appointments->links() }}
        </div>
    </div>

</div>
</x-app-layout>
