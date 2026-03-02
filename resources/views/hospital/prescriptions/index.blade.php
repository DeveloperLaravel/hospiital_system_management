<x-app-layout>

<div
x-data="prescriptionCrud()"
class="p-6 bg-gray-50 min-h-screen"
dir="rtl"
>

<div class="max-w-7xl mx-auto">


<!-- header -->
<div class="flex justify-between mb-6">

<h1 class="text-2xl font-bold">
الوصفات الطبية
</h1>

<button
@click="create()"
class="bg-blue-600 text-white px-4 py-2 rounded"
>
إضافة وصفة
</button>

</div>



<!-- table -->
<div class="bg-white rounded shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-3">#</th>
<th>السجل الطبي</th>
<th>الطبيب</th>
<th>ملاحظات</th>
<th>إجراءات</th>

</tr>

</thead>

<tbody>

@foreach($prescriptions as $item)

<tr class="border-t">

<td class="p-3">
{{ $item->id }}
</td>

<td>
{{ $item->medicalRecord->id }}
</td>

<td>
{{ $item->doctor->name ?? '' }}
</td>

<td>
{{ $item->notes }}
</td>

<td class="space-x-2">

<button
@click="edit(
{{ $item->id }},
{{ $item->medical_record_id }},
{{ $item->doctor_id }},
`{{ $item->notes }}`
)"
class="text-blue-600"
>
تعديل
</button>


<form
method="POST"
action="{{ route('prescriptions.destroy',$item) }}"
class="inline"
>
@csrf
@method('DELETE')

<button
onclick="return confirm('حذف؟')"
class="text-red-600"
>
حذف
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>



<!-- modal -->
<div
x-show="open"
class="fixed inset-0 bg-black/40 flex items-center justify-center"
>

<div class="bg-white p-6 rounded w-96">

<h2 class="mb-4 font-bold text-lg"
x-text="isEdit ? 'تعديل' : 'إضافة'"
></h2>


<form
:action="isEdit ? '/prescriptions/'+id : '/prescriptions'"
method="POST"
>

@csrf

<template x-if="isEdit">
<input type="hidden" name="_method" value="PUT">
</template>



<select
name="medical_record_id"
x-model="medical_record_id"
class="w-full border p-2 mb-3"
required
>

<option value="">السجل الطبي</option>

@foreach($records as $record)

<option value="{{ $record->id }}">
{{ $record->id }}
</option>

@endforeach

</select>



<select
name="doctor_id"
x-model="doctor_id"
class="w-full border p-2 mb-3"
required
>

<option value="">
الطبيب
</option>

@foreach($doctors as $doctor)

<option value="{{ $doctor->id }}">
{{ $doctor->name }}
</option>

@endforeach

</select>



<textarea
name="notes"
x-model="notes"
class="w-full border p-2 mb-3"
placeholder="ملاحظات"
></textarea>



<div class="flex justify-end gap-2">

<button
type="button"
@click="open=false"
class="px-4 py-2 bg-gray-300 rounded"
>
إلغاء
</button>

<button
class="px-4 py-2 bg-blue-600 text-white rounded"
>
حفظ
</button>

</div>

</form>

</div>

</div>



</div>



<script>

function prescriptionCrud(){

return {

open:false,
isEdit:false,

id:null,
medical_record_id:null,
doctor_id:null,
notes:'',


create(){

this.open=true
this.isEdit=false

this.id=null
this.notes=''

},

edit(id,record,doctor,notes){

this.open=true
this.isEdit=true

this.id=id
this.medical_record_id=record
this.doctor_id=doctor
this.notes=notes

}

}

}

</script>


</x-app-layout>
