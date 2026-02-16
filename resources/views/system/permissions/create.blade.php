<x-app-layout title="إضافة صلاحية">
    <main class="p-6 flex-1 overflow-auto bg-gray-50 min-h-screen" dir="rtl">

        <h2 class="text-2xl font-bold mb-4 text-right">إضافة صلاحية</h2>

        <form method="POST" action="{{ route('permissions.store') }}"
              class="bg-white p-6 rounded shadow space-y-4 text-right">
            @csrf

            <div>
                <label class="block mb-1">اسم الصلاحية</label>
                <input type="text" name="name"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    حفظ
                </button>
            </div>

        </form>
    </main>
</x-app-layout>
