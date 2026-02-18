<x-app-layout title="دواء">
<main class="p-6">

<form method="POST"
action="{{ isset($medication) ? route('medicines.update',$medicine) : route('medicines.store') }}"
class="bg-white p-4 rounded shadow">

@csrf
@if(isset($medication)) @method('PUT') @endif

<input name="name" placeholder="اسم الدواء"
value="{{ $medication->name ?? '' }}" class="border p-2 w-full mb-2">

<input name="quantity" type="number"
value="{{ $Medication->quantity ?? 0 }}"
class="border p-2 w-full mb-2">

<input name="price" type="number" step="0.01"
value="{{ $medicine->price ?? 0 }}"
class="border p-2 w-full mb-2">

<input name="expiry_date" type="date"
value="{{ $medication->expiry_date ?? '' }}"
class="border p-2 w-full mb-2">

<button class="bg-green-600 text-white px-4 py-2 rounded">
حفظ
</button>

</form>

</main>
</x-app-layout>
