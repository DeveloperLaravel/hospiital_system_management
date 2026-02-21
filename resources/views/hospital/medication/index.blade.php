<x-app-layout>
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Medicines Management</h1>

        @can('medicine-create')
        <button onclick="openModal()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Add Medicine
        </button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">Expiry</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $medicine)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $medicine->name }}</td>
                    <td class="px-4 py-3">{{ $medicine->type }}</td>
                    <td class="px-4 py-3">{{ $medicine->price }}</td>
                    <td class="px-4 py-3">{{ $medicine->quantity }}</td>
                    <td class="px-4 py-3">{{ $medicine->expiry_date }}</td>
                    <td class="px-4 py-3 text-center flex gap-2 justify-center">

                        @can('medicine-edit')
                        <button onclick="editMedicine({{ $medicine }})"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </button>
                        @endcan

                        @can('medicine-delete')
                        <form method="POST" action="{{ route('medicines.destroy',$medicine) }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Delete
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
<div id="medicineModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Add Medicine</h2>

        <form method="POST" id="medicineForm">
            @csrf
            <input type="hidden" id="methodField" name="_method">

            <input type="text" name="name" id="name" placeholder="Name"
                class="w-full border p-2 rounded mb-3">

            <input type="text" name="type" id="type" placeholder="Type"
                class="w-full border p-2 rounded mb-3">

            <input type="number" name="price" id="price" placeholder="Price"
                class="w-full border p-2 rounded mb-3">

            <input type="number" name="quantity" id="quantity" placeholder="Quantity"
                class="w-full border p-2 rounded mb-3">

            <input type="date" name="expiry_date" id="expiry_date"
                class="w-full border p-2 rounded mb-3">

            <textarea name="description" id="description"
                class="w-full border p-2 rounded mb-3"
                placeholder="Description"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(){
    document.getElementById('medicineForm').action = "{{ route('medicines.store') }}";
    document.getElementById('methodField').value = "";
    document.getElementById('modalTitle').innerText = "Add Medicine";
    document.getElementById('medicineModal').classList.remove('hidden');
}

function editMedicine(medicine){
    openModal();
    document.getElementById('medicineForm').action = `/medicines/${medicine.id}`;
    document.getElementById('methodField').value = "PUT";
    document.getElementById('modalTitle').innerText = "Edit Medicine";

    name.value = medicine.name;
    type.value = medicine.type;
    price.value = medicine.price;
    quantity.value = medicine.quantity;
    expiry_date.value = medicine.expiry_date;
    description.value = medicine.description;
}

function closeModal(){
    document.getElementById('medicineModal').classList.add('hidden');
}
</script>

</x-app-layout>
