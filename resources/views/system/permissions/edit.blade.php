<x-app-layout title="تعديل صلاحية">
 <main class="p-6 flex-1 overflow-auto">

<h2 class="text-2xl font-bold mb-4">تعديل صلاحية</h2>
<div>

<form method="POST"
      action="{{ route('permissions.update', $permission) }}"
      class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')

    <input type="text"
           name="name"
           value="{{ $permission->name }}"
           class="w-full border rounded px-3 py-2">

       
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition"> تحديث</button>

</form>
    
</div>
 </main>
</x-app-layout>
