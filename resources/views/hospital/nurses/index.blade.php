<x-app-layout>

<div class="p-6 space-y-6 rtl" dir="rtl">

    {{-- ========================= --}}
    {{-- عنوان الصفحة --}}
    {{-- ========================= --}}
    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-bold text-gray-800">
            إدارة الممرضات
        </h1>

    </div>

    {{-- ========================= --}}
    {{-- رسائل النجاح --}}
    {{-- ========================= --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ========================= --}}
    {{-- البحث والفلاتر --}}
    {{-- ========================= --}}
    <div class="bg-white p-4 rounded shadow">

        <form method="GET" class="flex gap-3 flex-wrap items-center">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="بحث بالاسم أو الهاتف"
                class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200"
            />

            <select
                name="department_id"
                class="border rounded px-3 py-2 focus:ring focus:ring-blue-200"
            >
                <option value="">كل الأقسام</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                بحث
            </button>

            <a href="{{ route('nurses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                إعادة
            </a>

        </form>

    </div>

    {{-- ========================= --}}
    {{-- إضافة ممرضة جديدة --}}
    {{-- ========================= --}}
    @can('nurses.create')
    <div class="bg-white p-4 rounded shadow">

        <h2 class="font-bold mb-3 text-gray-700">
            إضافة ممرضة جديدة
        </h2>

        <form method="POST" action="{{ route('nurses.store') }}" class="flex gap-3 flex-wrap items-center">

            @csrf

            <input name="name" placeholder="الاسم" class="border rounded px-3 py-2 w-48 focus:ring focus:ring-green-200" required />
            <input name="phone" placeholder="الهاتف" class="border rounded px-3 py-2 w-48 focus:ring focus:ring-green-200" />

            <select name="department_id" class="border rounded px-3 py-2 focus:ring focus:ring-green-200" required>
                <option value="">اختر القسم</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>

            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                إضافة
            </button>

        </form>

    </div>
    @endcan

    {{-- ========================= --}}
    {{-- جدول البيانات --}}
    {{-- ========================= --}}
    <div class="bg-white rounded shadow overflow-x-auto">

        <table class="w-full text-sm text-right">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">الاسم</th>
                    <th class="p-3">الهاتف</th>
                    <th class="p-3">القسم</th>
                    <th class="p-3">التحكم</th>
                </tr>
            </thead>

            <tbody>
                @forelse($nurses as $nurse)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3">{{ $nurse->id }}</td>
                    <td class="p-3">{{ $nurse->name }}</td>
                    <td class="p-3">{{ $nurse->phone ?? '-' }}</td>
                    <td class="p-3">{{ $nurse->department->name ?? '-' }}</td>
                    <td class="p-3 flex gap-2">

                        {{-- تعديل --}}
                        @can('nurses.edit')
                        <form method="POST" action="{{ route('nurses.update',$nurse) }}" class="flex gap-1 flex-wrap items-center">
                            @csrf
                            @method('PUT')

                            <input name="name" value="{{ $nurse->name }}" class="border px-2 py-1 w-28 focus:ring focus:ring-yellow-200" />
                            <input name="phone" value="{{ $nurse->phone }}" class="border px-2 py-1 w-28 focus:ring focus:ring-yellow-200" />

                            <select name="department_id" class="border px-2 py-1 focus:ring focus:ring-yellow-200">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected($nurse->department_id == $department->id)>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded transition">
                                حفظ
                            </button>
                        </form>
                        @endcan

                        {{-- حذف --}}
                        @can('nurses.delete')
                        <form method="POST" action="{{ route('nurses.destroy',$nurse) }}" onsubmit="return confirm('هل تريد الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition">
                                حذف
                            </button>
                        </form>
                        @endcan

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- pagination --}}
    <div class="mt-4">
        {{ $nurses->links() }}
    </div>

</div>

</x-app-layout>
