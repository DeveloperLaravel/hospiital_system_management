  <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- جدول التنبيهات --}}
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alerts as $alert)
                        <tr class="{{ $alert->is_read ? 'bg-gray-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alert->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alert->medication->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $alert->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($alert->is_read)
                                    <span class="text-green-600 font-semibold">Read</span>
                                @else
                                    <span class="text-red-600 font-semibold">Unread</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alert->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right flex space-x-2 justify-end">
                                @if(!$alert->is_read)
                                <form action="{{ route('stock-alerts.markRead', $alert) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-900">Mark as Read</button>
                                </form>
                                @endif
                                <form action="{{ route('stock-alerts.destroy', $alert) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this alert?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 px-6 py-3">
                    {{ $alerts->links() }}
                </div>
            </div>
        </div>
    </div>