<div class="overflow-x-auto bg-white shadow-lg rounded-xl">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">البريد الإلكتروني</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الأدوار</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50 transition duration-300">
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->status ? 'مفعل' : 'موقوف' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                    <a href="{{ route('users.edit', $user) }}"
                       class="p-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg shadow transition duration-300"
                       title="تعديل">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536L12 18H9v-5z"/>
                        </svg>
                    </a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow transition duration-300"
                                title="حذف">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
</div>
