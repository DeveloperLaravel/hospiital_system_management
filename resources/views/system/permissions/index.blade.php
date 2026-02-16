<x-app-layout title="إدارة الصلاحيات">
 <main class="p-6 flex-1 overflow-auto">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold">إدارة الصلاحيات</h2>
        <a href="{{ route('permissions.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
           إضافة صلاحية
        </a>
    </div>

    @session('success')
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endsession

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">اسم الصلاحية</th>
                    <th class="p-3 text-center">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($permissions as $permission)
                    <tr class="border-t">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-semibold text-blue-600">
                            {{ $permission->name }}
                        </td>
                        <td class="p-3 text-center space-x-2">

                            <a href="{{ route('permissions.edit', $permission) }}"
                               class="bg-yellow-400 text-white px-3 py-1 rounded">
                               تعديل
                            </a>

                            <form method="POST"
                                  action="{{ route('permissions.destroy', $permission) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    حذف
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-red-500">
                            لا توجد صلاحيات بعد
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
 </main>
</x-app-layout>
