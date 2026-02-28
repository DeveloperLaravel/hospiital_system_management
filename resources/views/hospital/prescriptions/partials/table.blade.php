@forelse($prescriptions as $prescription)
<tr class="border-b hover:bg-gray-50">
    <td class="p-3">{{ $prescription->id }}</td>
    <td>{{ $prescription->medicalRecord->patient->name ?? '-' }}</td>
    <td>{{ $prescription->doctor->name ?? '-' }}</td>
    <td>
        <ul class="list-disc list-inside">
            @foreach($prescription->items as $item)
                <li>
                    {{ $item->medication->name ?? '-' }}
                    @if($item->dosage), {{ $item->dosage }}@endif
                    @if($item->frequency), {{ $item->frequency }}@endif
                    @if($item->duration), {{ $item->duration }}@endif
                    @if($item->quantity), كمية: {{ $item->quantity }}@endif
                    @if($item->instructions), {{ $item->instructions }}@endif
                </li>
            @endforeach
        </ul>
    </td>
    <td>{{ $prescription->notes ?? '-' }}</td>
    <td class="space-x-2">
        <a href="#" onclick="printPrescription({{ $prescription->id }})" class="text-blue-600">طباعة</a>
        <a href="#" onclick="editPrescription({{ $prescription->id }})" class="text-yellow-600">تعديل</a>
        <button onclick="deletePrescription({{ $prescription->id }})" class="text-red-600">حذف</button>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="p-3 text-center text-gray-500">لا توجد وصفات</td>
</tr>
@endforelse

{{-- Pagination --}}
<tr>
    <td colspan="6" class="p-3 text-center">
        {{ $prescriptions->links() }}
    </td>
</tr>