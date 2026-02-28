<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    {{-- رسالة --}}
    @if(session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
<a href="{{ route('prescriptions.pdf', $prescription->id ?? 0) }}"
   class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
   طباعة PDF للوصفة
</a>
    {{-- نموذج إضافة --}}
    <div class="bg-white p-6 rounded shadow mb-6">

        <h2 class="font-bold mb-4">إضافة عنصر للوصفة</h2>
<!-- Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded w-96">
        <h2 class="font-bold mb-4">تعديل العنصر</h2>
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <select name="medication_id" id="medication" class="border p-2 rounded w-full mb-2">
                @foreach($medications as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                @endforeach
            </select>

            <input type="text" name="dosage" id="dosage" class="border p-2 rounded w-full mb-2" placeholder="الجرعة">
            <input type="text" name="frequency" id="frequency" class="border p-2 rounded w-full mb-2" placeholder="التكرار">
            <input type="number" name="duration" id="duration" class="border p-2 rounded w-full mb-2" placeholder="المدة">
            <input type="number" name="quantity" id="quantity" class="border p-2 rounded w-full mb-2" placeholder="الكمية">
            <textarea name="instructions" id="instructions" class="border p-2 rounded w-full mb-2" placeholder="تعليمات"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-3 py-1 rounded">إلغاء</button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">حفظ</button>
            </div>
        </form>
    </div>
</div>
        <form method="POST" action="{{ route('prescription-items.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <select name="prescription_id" class="border p-2 rounded" required>
                    <option value="">اختر الوصفة</option>
                    @foreach($prescriptions as $p)
                        <option value="{{ $p->id }}">
                            رقم الوصفة {{ $p->id }}
                        </option>
                    @endforeach
                </select>

                <select name="medication_id" class="border p-2 rounded" required>
                    <option value="">اختر الدواء</option>
                    @foreach($medications as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="dosage" placeholder="الجرعة (مثال: 500mg)" class="border p-2 rounded">
                <input type="text" name="frequency" placeholder="التكرار (مثال: 3 مرات يوميًا)" class="border p-2 rounded">
                <input type="number" name="duration" placeholder="المدة (أيام)" class="border p-2 rounded" min="1">
                <input type="number" name="quantity" placeholder="الكمية" class="border p-2 rounded" min="1">
                <textarea name="instructions" placeholder="تعليمات إضافية" class="border p-2 rounded col-span-2"></textarea>

            </div>

            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                حفظ
            </button>

        </form>

    </div>

    {{-- جدول --}}
    <div class="bg-white p-6 rounded shadow">

        <h2 class="font-bold mb-4">عناصر الوصفات</h2>

        <table class="w-full border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">الوصفة</th>
                    <th class="p-2">الدواء</th>
                    <th class="p-2">الجرعة</th>
                    <th class="p-2">التكرار</th>
                    <th class="p-2">المدة</th>
                    <th class="p-2">الكمية</th>
                    <th class="p-2">تعليمات</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>

            <tbody>

            @foreach($items as $item)
                <tr class="border-t">
                    <td class="p-2">#{{ $item->prescription_id }}</td>
                    <td class="p-2">{{ $item->medication->name }}</td>
                    <td class="p-2">{{ $item->dosage }}</td>
                    <td class="p-2">{{ $item->frequency }}</td>
                    <td class="p-2">{{ $item->duration }}</td>
                    <td class="p-2">{{ $item->quantity }}</td>
                    <td class="p-2">{{ $item->instructions ?? '-' }}</td>
                    <td class="p-2 flex gap-2">
                        {{-- حذف --}}
                        <form method="POST" action="{{ route('prescription-items.destroy',$item) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('حذف؟')" class="bg-red-500 text-white px-3 py-1 rounded">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>

        <div class="mt-4">
            {{ $items->links() }}
        </div>

    </div>

</div>
<script>
function openModal(id, medication, dosage, frequency, duration, quantity, instructions) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');

    document.getElementById('editForm').action = '/prescription-items/' + id;
    document.getElementById('medication').value = medication;
    document.getElementById('dosage').value = dosage;
    document.getElementById('frequency').value = frequency;
    document.getElementById('duration').value = duration;
    document.getElementById('quantity').value = quantity;
    document.getElementById('instructions').value = instructions;
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
</x-app-layout>