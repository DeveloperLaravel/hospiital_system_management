<x-app-layout title="الأدوار والصلاحيات">
    <main class="p-4 sm:p-6 lg:p-8 flex-1 overflow-auto">

        <!-- Cards الاحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
                <p class="text-3xl sm:text-4xl font-bold text-blue-600">120</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">الأطباء</h2>
                <p class="text-3xl sm:text-4xl font-bold text-green-600">25</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">المواعيد</h2>
                <p class="text-3xl sm:text-4xl font-bold text-yellow-500">43</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">الفواتير</h2>
                <p class="text-3xl sm:text-4xl font-bold text-red-500">18</p>
            </div>
        </div>

        <!-- عنوان الصفحة + زر الإضافة -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-8 mb-4 gap-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-700">إدارة الأدوار</h2>
            <a href="{{ route('roles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة دور جديد
            </a>
        </div>

        <!-- جدول الأدوار -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الدور</th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الصلاحيات</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $role)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 sm:px-6 py-4 text-right">{{ $loop->iteration }}</td>
                            <td class="px-4 sm:px-6 py-4 text-right font-semibold text-gray-800">{{ $role->name }}</td>
                            <td class="px-4 sm:px-6 py-4 text-right flex flex-wrap gap-1">
                                @foreach($role->permissions as $perm)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $perm->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-center flex flex-wrap justify-center gap-2">
                                <a href="{{ route('roles.edit', $role) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">تعديل</a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </main>
</x-app-layout>
