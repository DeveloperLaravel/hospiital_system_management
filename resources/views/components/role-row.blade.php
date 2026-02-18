@props(['role'])

<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4 text-right text-gray-700">{{ $loop->iteration }}</td>
    <td class="px-6 py-4 text-right font-semibold text-gray-800">{{ $role->name }}</td>
    <td class="px-6 py-4 text-right flex flex-wrap gap-2">
        @foreach($role->permissions as $perm)
            <x-permission-badge :permission="$perm->name" />
        @endforeach
    </td>
    <td class="px-6 py-4 text-center flex flex-wrap justify-center gap-2">
        <a href="{{ route('roles.edit', $role) }}" class="flex items-center gap-1 bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-5-5l5-5m0 0L13 7m5-5v5" />
            </svg>
            تعديل
        </a>
        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
            @csrf
            @method('DELETE')
            <button class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a2 2 0 00-2 2v0a2 2 0 002 2h4a2 2 0 002-2v0a2 2 0 00-2-2m-4 0V3m4 0V3" />
                </svg>
                حذف
            </button>
        </form>
    </td>
</tr>
