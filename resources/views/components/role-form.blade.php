@props(['editRole' => null, 'permissions'])

<div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
    <form method="POST" action="{{ isset($editRole) ? route('roles.update', $editRole) : route('roles.store') }}">
        @csrf
        @if(isset($editRole))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">اسم الدور</label>
            <input type="text" name="name" value="{{ old('name', $editRole->name ?? '') }}" class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">الصلاحيات</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                @foreach($permissions as $perm)
                    <label class="inline-flex items-center gap-2 p-1 rounded hover:bg-gray-100 transition cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                               @if(isset($editRole) && $editRole->hasPermissionTo($perm->name)) checked @endif>
                        <span class="text-sm">{{ $perm->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  @if(isset($editRole))
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  @else
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  @endif
                </svg>
                {{ isset($editRole) ? 'تحديث الدور' : 'حفظ الدور' }}
            </button>

            @if(isset($editRole))
                <a href="{{ route('roles.index') }}" class="text-gray-600 hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    إلغاء التعديل
                </a>
            @endif
        </div>
    </form>
</div>
