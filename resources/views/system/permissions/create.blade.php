<x-app-layout title="إضافة صلاحية">
 <main class="p-6 flex-1 overflow-auto">
<h2 class="text-2xl font-bold mb-4">إضافة صلاحية</h2>

<form method="POST" action="{{ route('permissions.store') }}"
      class="bg-white p-6 rounded shadow space-y-4">
    @csrf

    <div>
        <label class="block mb-1">اسم الصلاحية</label>
        <input type="text" name="name"
               class="w-full border rounded px-3 py-2">
        @error('name')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        حفظ
    </button>

</form>
</main>
</x-app-layout>
