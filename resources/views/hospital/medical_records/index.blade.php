<x-app-layout title="السجل الطبي">
<main class="p-6 text-right" dir="rtl">

<h2 class="text-xl font-bold mb-4">السجلات الطبية</h2>

@if(session('success'))
<div class="bg-green-100 border border-green-300 p-3 mb-3 rounded">
    {{ session('success') }}
</div>
@endif

@can('medical_records.create')
<form method="POST" action="{{ route('medical_records.store') }}"
class="bg-white p-6 rounded-xl shadow mb-6 space-y-3">
@csrf

<label class="block font-semibold">المريض</label>
<select name="patient_id" class="border p-2 w-full rounded">
@foreach($patients as $patient)
<option value="{{ $patient->id }}"
{{ old('patient_id') == $patient->id ? 'selected' : '' }}>
{{ $patient->name }}
</option>
@endforeach
</select>

<label class="block font-semibold">الطبيب</label>
<select name="doctor_id" class="border p-2 w-full rounded">
@foreach($doctors as $doctor)
<option value="{{ $doctor->id }}"
{{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
{{ $doctor->name }}
</option>
@endforeach
</select>

<label class="block font-semibold">التشخيص</label>
<textarea name="diagnosis" class="border p-2 w-full rounded"
placeholder="التشخيص">{{ old('diagnosis') }}</textarea>

<label class="block font-semibold">العلاج</label>
<textarea name="treatment" class="border p-2 w-full rounded"
placeholder="العلاج">{{ old('treatment') }}</textarea>

<label class="block font-semibold">ملاحظات</label>
<textarea name="notes" class="border p-2 w-full rounded"
placeholder="ملاحظات">{{ old('notes') }}</textarea>

<div class="text-left">
<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
حفظ
</button>
</div>

</form>
@endcan

<table class="w-full bg-white shadow rounded text-right overflow-hidden">
<tr class="bg-gray-100">
<th class="p-3">المريض</th>
<th class="p-3">الطبيب</th>
<th class="p-3">التشخيص</th>
<th class="p-3">العمليات</th>
</tr>

@foreach($records as $record)
<tr class="border-t hover:bg-gray-50">
<td class="p-3">{{ $record->patient?->name ?? '-' }}</td>
<td class="p-3">{{ $record->doctor?->name ?? '-' }}</td>
<td class="p-3">{{ $record->diagnosis }}</td>

<td class="p-3 flex justify-end gap-2">
@can('medical_records.delete')
<form method="POST" action="{{ route('medical_records.destroy',$record) }}">
@csrf
@method('DELETE')
<button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
حذف
</button>
</form>
@endcan
</td>
</tr>
@endforeach

</table>

</main>
</x-app-layout>
