<x-app-layout>
    <main class="p-6 flex-1 overflow-auto" dir="rtl" lang="ar">
        <div class="p-6">

            @can('department-create')
            <a href="{{ route('departments.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block transition">
               إضافة قسم
            </a>
            @endcan

            <table class="w-full mt-4 border border-gray-200 text-right">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border-b">الاسم</th>
                        <th class="p-2 border-b">الوصف</th>
                        <th class="p-2 border-b flex gap-2">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border-b">{{ $department->name }}</td>
                        <td class="p-2 border-b">{{ $department->description }}</td>
                        <td class="p-2 border-b flex gap-2">

                            @can('department-edit')
                            <a href="{{ route('departments.edit',$department->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded transition">
                               تعديل
                            </a>
                            @endcan

                            @can('department-delete')
                            <form method="POST" action="{{ route('departments.destroy',$department->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition">
                                    حذف
                                </button>
                            </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $departments->links() }}
            </div>

        </div>
    </main>
</x-app-layout>
