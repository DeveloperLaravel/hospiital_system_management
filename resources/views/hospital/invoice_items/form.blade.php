<x-app-layout>
<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">

<form method="POST"
      action="{{ isset($item)
          ? route('invoices.items.update', [$invoice,$item])
          : route('invoices.items.store', $invoice) }}">

    @csrf
    @if(isset($item))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label>اسم الخدمة</label>
        <input type="text"
               name="service"
               value="{{ old('service', $item->service ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label>السعر</label>
        <input type="number"
               step="0.01"
               name="price"
               value="{{ old('price', $item->price ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        حفظ
    </button>

</form>

</div>
</x-app-layout>
