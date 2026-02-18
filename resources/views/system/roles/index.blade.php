<x-app-layout title="إدارة الأدوار والصلاحيات">
    <main class="relative min-h-screen flex-1 overflow-auto" x-data="{ open: false, isEdit: false, roleId: null, roleName: '', selectedPermissions: [] }">

        <!-- خلفية احترافية -->
        <div class="fixed inset-0 -z-10">
            <img src="{{ asset('images/role.png') }}" class="w-full h-full object-cover" alt="Roles Background">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 via-black/60 to-indigo-900/70 backdrop-blur-sm"></div>
        </div>

        <div class="p-4 sm:p-6 lg:p-12 max-w-7xl mx-auto">

            <!-- العنوان + زر الإضافة -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 2-1 4-3 4s-3-2-3-4 1-4 3-4 3 2 3 4z M12 14c2 0 4 1 4 3s-2 3-4 3-4-1-4-3 2-3 4-3z" />
                    </svg>
                    إدارة الأدوار والصلاحيات
                </h1>

                <button
                    @click="open = true; isEdit=false; roleName=''; selectedPermissions=[]; roleId=null"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إضافة دور
                </button>
            </div>

            <!-- الرسائل -->
            <div class="mb-6 space-y-2">
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 p-3 rounded flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- جدول الأدوار -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <table class="w-full text-right">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs sm:text-sm font-medium tracking-wider">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">اسم الدور</th>
                            <th class="px-4 py-3">الصلاحيات</th>
                            <th class="px-4 py-3 text-center">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($roles as $role)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-medium text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 font-semibold text-gray-800 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 2-1 4-3 4s-3-2-3-4 1-4 3-4 3 2 3 4z M12 14c2 0 4 1 4 3s-2 3-4 3-4-1-4-3 2-3 4-3z" />
                                    </svg>
                                    {{ $role->name }}
                                </td>
                                <td class="px-4 py-4 flex flex-wrap gap-2">
                                    @foreach($role->permissions ?? collect() as $perm)
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs sm:text-sm px-2 py-1 rounded-full font-medium shadow-sm hover:bg-green-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-4 text-center flex flex-wrap justify-center gap-2">
                                    @can('role-edit')
                                        <button
                                            @click="open=true; isEdit=true; roleId={{ $role->id }}; roleName='{{ $role->name }}'; selectedPermissions=@json($role->permissions->pluck('id'))"
                                            class="bg-yellow-400 text-white px-3 py-1 rounded flex items-center gap-1 hover:bg-yellow-500 transition">
                                            تعديل
                                        </button>
                                    @endcan
                                    @can('role-delete')
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 text-white px-3 py-1 rounded flex items-center gap-1 hover:bg-red-600 transition">
                                                حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-red-500 font-semibold">لا توجد أدوار بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal إضافة / تعديل الدور -->
            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
                <div @click.away="open=false; isEdit=false; roleId=null; roleName=''; selectedPermissions=[]" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                    <h3 class="text-lg font-bold mb-4" x-text="isEdit ? 'تعديل الدور' : 'إضافة دور'"></h3>

                    <form :action="isEdit ? `/roles/${roleId}` : '{{ route('roles.store') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">اسم الدور</label>
                            <input type="text" name="name" x-model="roleName" class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">الصلاحيات</label>
                            <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                                @foreach($permissions as $perm)
                                    <label class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 rounded cursor-pointer hover:bg-gray-200 transition">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" x-model="selectedPermissions" class="accent-blue-500">
                                        <span class="text-gray-700 text-sm">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open=false; isEdit=false; roleId=null; roleName=''; selectedPermissions=[]" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition">إلغاء</button>
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition" x-text="isEdit ? 'تحديث' : 'إضافة'"></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
