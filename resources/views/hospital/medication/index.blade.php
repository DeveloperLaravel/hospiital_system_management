<x-app-layout title="الأدوية">
<main class="p-6">

@can('medicine-create')
<a href="{{ route('medicines.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">
إضافة دواء
</a>
@endcan

<table class="w-full mt-4 border">
<tr class="bg-gray-100">
<th>الاسم</th>
<th>الكمية</th>
<th>السعر</th>
<th>تاريخ الانتهاء</th>
<th>التحكم</th>
</tr>

@foreach($medicines as $medicine)
<tr class="border-t text-center">
<td>{{ $medicine->name }}</td>
<td>{{ $medicine->quantity }}</td>
<td>{{ $medicine->price }}</td>
<td>{{ $medicine->expiry_date }}</td>

<td class="space-x-2">
@can('medicine-edit')
<a href="{{ route('medicines.edit',$medicine) }}">✏️</a>
@endcan

@can('medicine-delete')
<form method="POST" action="{{ route('medicines.destroy',$medicine) }}" class="inline">
@csrf
@method('DELETE')
<button>🗑</button>
</form>
@endcan
</td>

</tr>
@endforeach
</table>

</main>
</x-app-layout>
