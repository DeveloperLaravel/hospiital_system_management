<x-app-layout title="تعديل الدور">
<main class="p-6 flex-1 overflow-auto">
    <br>
    <h2 class="text-2xl font-bold mb-4">تعديل الدور</h2>

    <form action="{{ route('roles.update', $role) }}"
          method="POST"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        @method('PUT')

        <!-- اسم الدور -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">
                اسم الدور
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $role->name) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">

            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- الصلاحيات -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">
                الصلاحيات
            </label>

            @if($permissions->isEmpty())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                    لا توجد صلاحيات متاحة
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 bg-gray-50 p-2 rounded hover:bg-blue-50 transition cursor-pointer">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   class="rounded border-gray-300"
                                   {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>

                            <span class="text-gray-700 text-sm">
                                {{ $permission->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif

            @error('permissions')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- زر الحفظ -->
        <div class="flex justify-end">
            <button class="bg-yellow-500 text-white px-5 py-2 rounded shadow hover:bg-yellow-600 transition">
                تحديث الدور
            </button>
        </div>

    </form>
</main>
</x-app-layout>
