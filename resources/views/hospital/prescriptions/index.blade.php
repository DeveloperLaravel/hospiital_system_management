<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

<h1 class="text-2xl font-bold mb-6">الوصفات الطبية</h1>

<div id="success-msg" class="bg-green-100 text-green-700 p-3 rounded mb-4 hidden"></div>

<div class="mb-4 flex gap-2">
<input type="text" id="search" class="border p-2 rounded w-full" placeholder="ابحث باسم الدواء أو المريض">
<button onclick="loadPrescriptions()" class="bg-blue-600 text-white px-4 py-2 rounded">بحث</button>
</div>

<button onclick="openPrescriptionModal()" class="bg-green-600 text-white px-6 py-2 rounded mb-4">إضافة وصفة جديدة</button>

<div class="bg-white shadow rounded overflow-x-auto">
<table class="w-full min-w-[900px]">
<thead class="bg-gray-100">
<tr>
<th class="p-3 border">#</th>
<th class="p-3 border">المريض</th>
<th class="p-3 border">الطبيب</th>
<th class="p-3 border">الأدوية</th>
<th class="p-3 border">ملاحظات</th>
<th class="p-3 border">تحكم</th>
</tr>
</thead>
<tbody id="prescriptions-table"></tbody>
</table>
</div>

<div id="pagination" class="mt-4"></div>

</div>

{{-- Modal --}}
<div id="prescription-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
<div class="bg-white p-6 rounded-lg w-11/12 max-w-4xl max-h-[90vh] overflow-y-auto">
<h2 id="modal-title" class="text-xl font-bold mb-4">إضافة وصفة</h2>

<form id="prescription-form">
@csrf
<input type="hidden" id="prescription_id">

<div class="mb-4">
<label class="block font-semibold">السجل الطبي</label>
<select id="medical_record_id" name="medical_record_id" class="border p-2 w-full">
<option value="">اختر السجل</option>
@foreach($records as $record)
<option value="{{ $record->id }}">{{ $record->patient->name }} - {{ $record->visit_date }}</option>
@endforeach
</select>
</div>

<div class="mb-4">
<label class="block font-semibold">الطبيب</label>
<select id="doctor_id" name="doctor_id" class="border p-2 w-full">
<option value="">اختر الطبيب</option>
@foreach($doctors as $doctor)
<option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
@endforeach
</select>
</div>

<div class="mb-4">
<label class="block font-semibold">ملاحظات</label>
<textarea name="notes" id="notes" class="border p-2 w-full"></textarea>
</div>

<h3 class="text-lg font-bold mb-2 mt-4">الأدوية</h3>
<table class="w-full mb-4 border">
<thead class="bg-gray-100">
<tr>
<th class="p-2 border">الدواء</th>
<th class="p-2 border">الجرعة</th>
<th class="p-2 border">التكرار</th>
<th class="p-2 border">المدة</th>
<th class="p-2 border">الكمية</th>
<th class="p-2 border">تعليمات</th>
<th class="p-2 border">حذف</th>
</tr>
</thead>
<tbody id="items-container">
<tr>
<td class="border p-1">
<select name="items[0][medication_id]" class="border p-1 w-full">
<option value="">اختر الدواء</option>
@foreach($medications as $med)
<option value="{{ $med->id }}">{{ $med->name }}</option>
@endforeach
</select>
</td>
<td class="border p-1"><input type="text" name="items[0][dosage]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[0][frequency]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[0][duration]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="number" name="items[0][quantity]" class="border p-1 w-full" min="1"></td>
<td class="border p-1"><input type="text" name="items[0][instructions]" class="border p-1 w-full"></td>
<td class="border p-1 text-center">
<button type="button" onclick="removeRow(this)" class="text-red-600 font-bold">×</button>
</td>
</tr>
</tbody>
</table>

<button type="button" onclick="addRow()" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">إضافة دواء</button>
<br>
<button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">حفظ</button>
<button type="button" onclick="closePrescriptionModal()" class="bg-red-600 text-white px-4 py-2 rounded ml-2">إغلاق</button>
</form>
</div>
</div>

{{-- Print area --}}
<div id="print-area" class="hidden"><div id="print-content"></div></div>

<script>
let index = 1;

function openPrescriptionModal() {
    document.getElementById('prescription-modal').classList.remove('hidden');
    document.getElementById('modal-title').innerText = 'إضافة وصفة';
    document.getElementById('prescription-form').reset();
    index = 1;
    document.getElementById('items-container').innerHTML = `
<tr>
<td class="border p-1">
<select name="items[0][medication_id]" class="border p-1 w-full">
<option value="">اختر الدواء</option>
@foreach($medications as $med)
<option value="{{ $med->id }}">{{ $med->name }}</option>
@endforeach
</select>
</td>
<td class="border p-1"><input type="text" name="items[0][dosage]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[0][frequency]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[0][duration]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="number" name="items[0][quantity]" class="border p-1 w-full" min="1"></td>
<td class="border p-1"><input type="text" name="items[0][instructions]" class="border p-1 w-full"></td>
<td class="border p-1 text-center">
<button type="button" onclick="removeRow(this)" class="text-red-600 font-bold">×</button>
</td>
</tr>`;
}

function closePrescriptionModal() { document.getElementById('prescription-modal').classList.add('hidden'); }
function addRow() {
    const container = document.getElementById('items-container');
    const row = document.createElement('tr');
    row.innerHTML = `
<td class="border p-1">
<select name="items[\${index}][medication_id]" class="border p-1 w-full">
<option value="">اختر الدواء</option>
@foreach($medications as $med)
<option value="{{ $med->id }}">{{ $med->name }}</option>
@endforeach
</select>
</td>
<td class="border p-1"><input type="text" name="items[\${index}][dosage]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[\${index}][frequency]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="text" name="items[\${index}][duration]" class="border p-1 w-full"></td>
<td class="border p-1"><input type="number" name="items[\${index}][quantity]" class="border p-1 w-full" min="1"></td>
<td class="border p-1"><input type="text" name="items[\${index}][instructions]" class="border p-1 w-full"></td>
<td class="border p-1 text-center">
<button type="button" onclick="removeRow(this)" class="text-red-600 font-bold">×</button>
</td>`;
    container.appendChild(row); index++;
}
function removeRow(btn){btn.closest('tr').remove();}

// AJAX form submit
document.getElementById('prescription-form').addEventListener('submit',function(e){
    e.preventDefault();
    let formData = new FormData(this);
    let id = document.getElementById('prescription_id').value;
    let url = id ? `/prescriptions/${id}` : `/prescriptions`;
    let method = id ? 'PUT' : 'POST';

    fetch(url, {method:method, headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:formData})
    .then(res=>res.json())
    .then(data=>{
        closePrescriptionModal();
        document.getElementById('success-msg').innerText = data.message;
        document.getElementById('success-msg').classList.remove('hidden');
        loadPrescriptions();
    });
});

// Load prescriptions table via AJAX
function loadPrescriptions(){
    let search = document.getElementById('search').value;
    fetch(`/prescriptions?search=${search}&ajax=1`)
        .then(res=>res.text())
        .then(html=>{document.getElementById('prescriptions-table').innerHTML = html;});
}

// Print prescription
function printPrescription(id){
    fetch(`/prescriptions/${id}?print=1`)
        .then(res=>res.text())
        .then(html=>{
            const printContent = document.getElementById('print-content');
            printContent.innerHTML = html;
            window.print();
        });
}

loadPrescriptions();
</script>

<style>
@media print {
    body * {visibility:hidden;}
    #print-content, #print-content * {visibility:visible;}
    #print-content {position:absolute;left:0;top:0;width:100%;}
}
</style>
</x-app-layout>