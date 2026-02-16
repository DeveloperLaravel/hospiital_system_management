<x-app-layout title="الأدوار والصلاحيات">
   <main class="p-6 flex-1 overflow-auto">
    <!-- Cards الاحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
            <p class="text-3xl font-bold text-blue-600">120</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">الأطباء</h2>
            <p class="text-3xl font-bold text-green-600">25</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">المواعيد</h2>
            <p class="text-3xl font-bold text-yellow-500">43</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">الفواتير</h2>
            <p class="text-3xl font-bold text-red-500">18</p>
        </div>
    </div>

    <br>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">إدارة الأدوار</h2>
        {{-- @can('role-create') --}}
            <a href="{{ route('roles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">إضافة دور جديد</a>
        {{-- @endcan --}}
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الدور</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الصلاحيات</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($roles as $role)
                    <tr>
                        <td class="px-6 py-4 text-right">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-right font-semibold">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-right">
                            @foreach($role->permissions as $perm)
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">{{ $perm->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            {{-- @can('role-edit') --}}
                                <a href="{{ route('roles.edit', $role) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">تعديل</a>
                            {{-- @endcan --}}
                            {{-- @can('role-delete') --}}
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">حذف</button>
                                </form>
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   </main>
</x-app-layout>
