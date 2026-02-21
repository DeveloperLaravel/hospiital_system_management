<x-app-layout>
<div class="p-4 sm:p-6 bg-gray-50 min-h-screen" dir="rtl" lang="ar">

    {{-- رسالة النجاح --}}
    @if(session()->has('message'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                إدارة المواعيد
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                عرض وتنظيم جميع مواعيد المرضى
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

            {{-- البحث --}}
            <form method="GET" action="{{ route('appointments.index') }}" class="relative w-full sm:w-64">
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="بحث باسم المريض..."
                       class="w-full pr-10 pl-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                <svg class="w-4 h-4 absolute right-3 top-3 text-gray-400"
                     fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
            </form>

            {{-- زر إضافة --}}
            @can('appointments-create')
            <a href="{{ route('appointments.create') }}"
               class="flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-xl shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
                إضافة موعد
            </a>
            @endcan
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4">المريض</th>
                        <th class="p-4">الطبيب</th>
                        <th class="p-4">التاريخ</th>
                        <th class="p-4">الوقت</th>
                        <th class="p-4">الحالة</th>
                        <th class="p-4">الإجراءات</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="p-4 font-medium text-gray-800">
                            {{ $appointment->patient->name }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $appointment->doctor->name }}
                        </td>

                        <td class="p-4">{{ $appointment->date }}</td>
                        <td class="p-4">{{ $appointment->time }}</td>

                        {{-- Badge Status --}}
                        <td class="p-4">
                            @switch($appointment->status)
                                @case('confirmed')
                                    <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                        مؤكد
                                    </span>
                                @break

                                @case('pending')
                                    <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                        قيد الانتظار
                                    </span>
                                @break

                                @case('completed')
                                    <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                        مكتمل
                                    </span>
                                @break

                                @default
                                    <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                        ملغي
                                    </span>
                            @endswitch
                        </td>

                        {{-- Actions --}}
                        <td class="p-4">
                            <div class="flex justify-center gap-2">

                                @can('appointments-edit')
                                <a href="{{ route('appointments.edit', $appointment) }}"
                                   class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-sm">
                                    تعديل
                                </a>
                                @endcan

                                @can('appointments-delete')
                                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('هل أنت متأكد من حذف الموعد؟')"
                                            class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm">
                                        حذف
                                    </button>
                                </form>
                                @endcan

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-gray-400">
                            لا توجد مواعيد
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden p-4 space-y-4">
            @forelse($appointments as $appointment)
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-gray-800">
                            {{ $appointment->patient->name }}
                        </h3>
                        <span class="text-xs text-gray-500">
                            {{ $appointment->date }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600">
                        الطبيب: {{ $appointment->doctor->name }}
                    </p>

                    <p class="text-sm text-gray-600">
                        الوقت: {{ $appointment->time }}
                    </p>

                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                            {{ $appointment->status }}
                        </span>

                        <div class="flex gap-2">
                            <a href="{{ route('appointments.edit', $appointment) }}"
                               class="text-xs bg-yellow-500 text-white px-2 py-1 rounded">
                                تعديل
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400">لا توجد مواعيد</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t">
            {{ $appointments->links() }}
        </div>

    </div>
</div>
</x-app-layout>
