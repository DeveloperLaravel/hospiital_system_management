<div class="p-6 text-black">
<h2 class="text-2xl font-bold mb-4 text-center">وصفة طبية</h2>

<p><strong>المريض:</strong> {{ $prescription->medicalRecord->patient->name }}</p>
<p><strong>الطبيب:</strong> {{ $prescription->doctor->name }}</p>
<p><strong>تاريخ الوصفة:</strong> {{ $prescription->created_at->format('d/m/Y') }}</p>
<p><strong>ملاحظات:</strong> {{ $prescription->notes ?? '-' }}</p>

<table class="w-full border mt-4">
<thead class="bg-gray-200">
<tr>
<th class="border p-2">الدواء</th>
<th class="border p-2">الجرعة</th>
<th class="border p-2">التكرار</th>
<th class="border p-2">المدة</th>
<th class="border p-2">الكمية</th>
<th class="border p-2">تعليمات</th>
</tr>
</thead>
<tbody>
@foreach($prescription->items as $item)
<tr>
<td class="border p-2">{{ $item->medication->name }}</td>
<td class="border p-2">{{ $item->dosage }}</td>
<td class="border p-2">{{ $item->frequency }}</td>
<td class="border p-2">{{ $item->duration }}</td>
<td class="border p-2">{{ $item->quantity }}</td>
<td class="border p-2">{{ $item->instructions ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>

<p class="mt-6 text-right">توقيع الطبيب: ____________________</p>
</div>