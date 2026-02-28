<x-app-layout title="إدارة الأدوية">
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl" lang="ar">

    {{-- رسالة النجاح --}}
    @if(session('message'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded shadow">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- نموذج إضافة / تعديل --}}
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h2 class="text-xl font-bold mb-4">إضافة / تعديل دواء</h2>

            <form id="medicationForm" method="POST" action="{{ route('medications.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="medication_id" id="medication_id">

                <div>
                    <label>اسم الدواء</label>
                    <input type="text" name="name" id="name" class="input" required>
                    @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label>النوع</label>
                    <input type="text" name="type" id="type" class="input">
                </div>

                <div>
                    <label>الوصف</label>
                    <textarea name="description" id="description" class="input"></textarea>
                </div>

                <div>
                    <label>الكمية</label>
                    <input type="number" name="quantity" id="quantity" class="input" required>
                </div>

                <div>
                    <label>الحد الأدنى للمخزون</label>
                    <input type="number" name="min_stock" id="min_stock" class="input" required>
                </div>

                <div>
                    <label>السعر</label>
                    <input type="number" step="0.01" name="price" id="price" class="input" required>
                </div>

                <div>
                    <label>تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="input">
                </div>

                <div>
                    <label>الحالة</label>
                    <select name="is_active" id="is_active" class="input">
                        <option value="1">نشط</option>
                        <option value="0">غير نشط</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary w-full">حفظ</button>
            </form>
        </div>

        {{-- جدول الأدوية --}}
        <div class="md:col-span-2 bg-white shadow-lg rounded-xl p-6 border border-gray-200 overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">قائمة الأدوية</h2>
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الانتهاء</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medications as $med)
                        <tr class="border-b">
                            <td>{{ $med->id }}</td>
                            <td>{{ $med->name }}</td>
                            <td>{{ $med->type ?? '-' }}</td>
                            <td>{{ $med->quantity }}</td>
                            <td>{{ $med->price }}</td>
                            <td>{{ $med->expiry_date ?? '-' }}</td>
                            <td>{{ $med->is_active ? 'نشط' : 'غير نشط' }}</td>
                            <td class="flex gap-2">
                                <button type="button" onclick="editMedication({{ $med }})" class="btn-edit">تعديل</button>
                                <form action="{{ route('medications.destroy', $med) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $medications->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function editMedication(med) {
    document.getElementById('medicationForm').action = `/medications/update/${med.id}`;
    document.getElementById('name').value = med.name;
    document.getElementById('type').value = med.type ?? '';
    document.getElementById('description').value = med.description ?? '';
    document.getElementById('quantity').value = med.quantity;
    document.getElementById('min_stock').value = med.min_stock;
    document.getElementById('price').value = med.price;
    document.getElementById('expiry_date').value = med.expiry_date ?? '';
    document.getElementById('is_active').value = med.is_active ? 1 : 0;
}
</script>
</x-app-layout>