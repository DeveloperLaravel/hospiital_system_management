<x-app-layout title="السجل الطبي">
<main class="p-6 text-right" dir="rtl">

<h2 class="text-xl font-bold mb-4">السجلات الطبية</h2>

@if(session('success'))
<div class="bg-green-100 p-2 mb-3">
    {{ session('success') }}
</div>
@endif

@can('medical_records.create')
<form method="POST" action="{{ route('medical_records.store') }}" class="bg-white p-4 rounded shadow mb-6">
@csrf

<select name="patient_id" class="border p-2 w-full mb-2">
@foreach($patients as $patient)
<option value="{{ $patient->id }}">{{ $patient->name }}</option>
@endforeach
</select>

<select name="doctor_id" class="border p-2 w-full mb-2">
@foreach($doctors as $doctor)
<option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
@endforeach
</select>

<textarea name="diagnosis" placeholder="التشخيص" class="border p-2 w-full mb-2"></textarea>
<textarea name="treatment" placeholder="العلاج" class="border p-2 w-full mb-2"></textarea>
<textarea name="notes" placeholder="ملاحظات" class="border p-2 w-full mb-2"></textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
حفظ
</button>
</form>
@endcan

<table class="w-full bg-white shadow rounded text-right">
<tr class="bg-gray-100">
<th class="p-2">المريض</th>
<th class="p-2">الطبيب</th>
<th class="p-2">التشخيص</th>
<th class="p-2">العمليات</th>
</tr>

@foreach($records as $record)
<tr class="border-t">
<td class="p-2">{{ $record->patient?->name }}</td>
<td class="p-2">{{ $record->doctor?->name }}</td>
<td class="p-2">{{ $record->diagnosis }}</td>

<td class="p-2 flex justify-end gap-2">
@can('medical_records.delete')
<form method="POST" action="{{ route('medical_records.destroy',$record) }}">
@csrf
@method('DELETE')
<button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
</form>
@endcan
</td>
</tr>
@endforeach

</table>

</main>
</x-app-layout>
