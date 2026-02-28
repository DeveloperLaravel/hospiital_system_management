<x-app-layout title="إدارة الصلاحيات">
    <main class="relative min-h-screen flex-1 overflow-auto bg-gray-50" x-data="{ open: false, isEdit: false, permissionId: null, permissionName: '' }">

        <!-- الخلفية مع طبقة تدرج -->
        <div class="fixed inset-0 -z-10">
            <img src="{{ asset('images/Permission.png') }}" class="w-full h-full object-cover" alt="Permissions Background">
            <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70 via-blue-700/40 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

            <!-- العنوان وزر الإضافة -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إدارة الصلاحيات
                </h2>
                  @can('permission-create')
                <button
                    @click="open = true; isEdit=false; permissionName=''; permissionId=null"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إضافة صلاحية
                </button>
                 @endcan
            </div>

            <!-- الرسائل -->
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 flex items-center gap-2 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- جدول الصلاحيات -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <table class="w-full text-right min-w-[320px]">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-medium tracking-wider">
                        <tr>
                            <th class="p-3">#</th>
                            <th class="p-3">اسم الصلاحية</th>
                            <th class="p-3 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3 font-semibold text-blue-600">{{ $permission->name }}</td>
                                <td class="p-3 text-center flex flex-wrap justify-center gap-2">

                                    <!-- تعديل -->
                                     @can('permission-edit')
                                    <button
                                        @click="open=true; isEdit=true; permissionId={{ $permission->id }}; permissionName={{ json_encode($permission->name) }}"
                                        class="bg-yellow-400 text-white px-3 py-1 rounded-lg flex items-center gap-1 hover:bg-yellow-500 transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h6M11 9h6M11 13h6M5 5h.01M5 9h.01M5 13h.01M5 17h14" />
                                        </svg>
                                        تعديل
                                    </button>
  @endcan
                                    <!-- حذف -->
                                        @can('permission-delete')
                                    <form method="POST" action="{{ route('permissions.destroy', $permission) }}" class="inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded-lg flex items-center gap-1 hover:bg-red-600 transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            حذف
                                        </button>
                                    </form>
  @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-red-500 font-semibold">
                                    لا توجد صلاحيات بعد
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal إضافة / تعديل صلاحية -->
            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
                <div @click.away="open=false; isEdit=false; permissionName=''; permissionId=null" class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800" x-text="isEdit ? 'تعديل الصلاحية' : 'إضافة صلاحية'"></h3>

                    <form :action="isEdit ? `/permissions/${permissionId}` : '{{ route('permissions.store') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">اسم الصلاحية</label>
                            <input type="text" name="name" x-model="permissionName" class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open=false; isEdit=false; permissionName=''; permissionId=null" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition">إلغاء</button>
                            <button type="submit" class="px-4 py-2 rounded bg-yellow-500 text-white hover:bg-yellow-600 transition" x-text="isEdit ? 'تحديث' : 'إضافة'"></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </main>
</x-app-layout>
