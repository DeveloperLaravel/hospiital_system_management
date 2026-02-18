<x-app-layout>
<main class="min-h-screen bg-gray-50 p-6 flex-1 overflow-auto"
      dir="rtl"
      x-data="{ open:false, isEdit:false, id:null, name:'', description:'' }">

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">إدارة الأقسام</h1>

        @can('department-create')
        <button
            @click="open=true; isEdit=false; name=''; description=''; id=null"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
            إضافة قسم
        </button>
        @endcan
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">الاسم</th>
                    <th class="p-3">الوصف</th>
                    <th class="p-3 text-center">التحكم</th>
                </tr>
            </thead>

            <tbody>
                @foreach($departments as $department)
                <tr class="border-t">
                    <td class="p-3">{{ $department->name }}</td>
                    <td class="p-3">{{ $department->description }}</td>
                    <td class="p-3 flex justify-center gap-2">

                        @can('department-edit')
                        <button
                            @click="
                                open=true;
                                isEdit=true;
                                id={{ $department->id }};
                                name={{ json_encode($department->name) }};
                                description={{ json_encode($department->description) }};
                            "
                            class="bg-yellow-400 px-3 py-1 rounded text-white">
                            تعديل
                        </button>
                        @endcan

                        @can('department-delete')
                        <form method="POST" action="{{ route('departments.destroy',$department->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 px-3 py-1 rounded text-white">
                                حذف
                            </button>
                        </form>
                        @endcan

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div x-show="open" class="fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-full max-w-md">

        <h2 class="text-lg font-bold mb-4"
            x-text="isEdit ? 'تعديل القسم' : 'إضافة قسم'"></h2>

        <form :action="isEdit ? `/departments/${id}` : '{{ route('departments.store') }}'" method="POST">
            @csrf

            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="mb-3">
                <label>اسم القسم</label>
                <input type="text" name="name" x-model="name" class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" x-model="description" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" @click="open=false" class="bg-gray-300 px-3 py-1 rounded">
                    إلغاء
                </button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">
                    حفظ
                </button>
            </div>
        </form>

    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
</main>
</x-app-layout>
