<x-app-layout>
          <main class="p-6 flex-1 overflow-auto">

<div class="p-6">

<form method="POST" action="{{ route('departments.store') }}">
@csrf

<input name="name" placeholder="اسم القسم" class="border p-2 w-full mb-3">

<textarea name="description" placeholder="الوصف"
class="border p-2 w-full"></textarea>

<button class="bg-blue-600 text-white px-4 py-2 mt-3 rounded">
حفظ
</button>

</form>

</div>
          </main>
</x-app-layout>
