<x-app-layout>
       <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Form لإضافة أو تعديل الدواء --}}
            <div class="mb-6 bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ isset($editingTransaction) ? 'Edit Transaction' : 'Add Transaction' }}
                </h3>

                <form wire:submit.prevent="saveTransaction">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Medication</label>
                            <select wire:model="medication_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Medication</option>
                                @foreach($medications as $med)
                                    <option value="{{ $med->id }}">{{ $med->name }}</option>
                                @endforeach
                            </select>
                            @error('medication_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select wire:model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Type</option>
                                <option value="in">In</option>
                                <option value="out">Out</option>
                            </select>
                            @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" wire:model="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1">
                            @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                {{ isset($editingTransaction) ? 'Update' : 'Add' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- جدول عرض التحركات --}}
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $tx)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tx->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tx->medication->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $tx->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tx->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tx->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tx->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex space-x-2 justify-end">
                                <button wire:click="editTransaction({{ $tx->id }})" 
                                        class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="deleteTransaction({{ $tx->id }})" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                        Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 px-6 py-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>