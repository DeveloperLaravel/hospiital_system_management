<x-app-layout title="إضافة دور جديد">
<main class="p-6 flex-1 overflow-auto">
    <br>
    <h2 class="text-2xl font-bold mb-4">إضافة دور جديد</h2>

    <form action="{{ route('roles.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium mb-1">اسم الدور</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" value="{{ old('name') }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
  <label class="block text-gray-700 font-medium mb-2">الصلاحيات</label>

@if($permissions->isEmpty())
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg shadow-sm">
        لا توجد صلاحيات متاحة حالياً.
        <div class="text-sm mt-1 text-red-500">
            يرجى إنشاء الصلاحيات أولاً قبل إضافة دور جديد.
        </div>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
        @foreach($permissions as $permission)
            <label class="flex items-center space-x-2 bg-gray-50 p-2 rounded hover:bg-gray-100 transition">
                <input type="checkbox"
                       name="permissions[]"
                       value="{{ $permission->name }}"
                       class="rounded border-gray-300 focus:ring focus:ring-blue-200">
                <span class="text-gray-700">{{ $permission->name }}</span>
            </label>
        @endforeach
    </div>
@endif

@error('permissions')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror

        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">حفظ</button>
    </form>
</main>
</x-app-layout>
