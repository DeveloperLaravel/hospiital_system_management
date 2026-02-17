<x-app-layout title="تعديل المستخدم">
      <main class="p-6 flex-1 overflow-auto" dir="rtl">

@if(session('success'))
<div class="bg-green-100 p-2 mb-3">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('users.update', $user) }}" class="bg-white p-4 rounded shadow">
    @csrf
    @method('PUT')

    <!-- عرض الـ ID فقط -->
    <div class="mb-2">
        <label class="block mb-1 font-bold">معرّف المستخدم (ID)</label>
        <input type="text" value="{{ $user->id }}" readonly class="border p-2 w-full bg-gray-100 cursor-not-allowed">
    </div>

    <!-- اسم المستخدم -->
    <div class="mb-2">
        <label class="block mb-1 font-bold">الاسم</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full">
        @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- البريد الإلكتروني -->
    <div class="mb-2">
        <label class="block mb-1 font-bold">البريد الإلكتروني</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full">
        @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">تحديث المستخدم</button>
</form>

</main>
</x-app-layout>
