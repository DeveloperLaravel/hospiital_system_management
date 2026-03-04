<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    {{-- رسائل النجاح والخطأ --}}
    @if(session('message'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- إحصائيات سريعة --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">إجمالي الأدوية</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">نشط</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">مخزون منخفض</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['low_stock'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">تنتهي قريباً</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['expiring_soon'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- نموذج إضافة / تعديل --}}
        <div class="bg-white p-6 rounded-2xl shadow-md w-full lg:w-1/3">
            <h2 class="text-xl font-bold mb-4">إضافة / تعديل دواء</h2>

            <form id="medicationForm" method="POST" action="{{ route('medications.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form_method" value="POST">
                <input type="hidden" name="medication_id" id="medication_id">

                <div>
                    <label class="block text-sm font-medium mb-1">اسم الدواء</label>
                    <input type="text" name="name" id="name" class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">النوع</label>
                    <input type="text" name="type" id="type" class="w-full rounded-xl border border-gray-300 px-4 py-2" placeholder="مثل: أقراص، شراب، حقن">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الوصف</label>
                    <textarea name="description" id="description" rows="2" class="w-full rounded-xl border border-gray-300 px-4 py-2"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">الكمية</label>
                        <input type="number" name="quantity" id="quantity" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">الحد الأدنى</label>
                        <input type="number" name="min_stock" id="min_stock" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">السعر</label>
                    <input type="number" step="0.01" name="price" id="price" class="w-full rounded-xl border border-gray-300 px-4 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الحالة</label>
                    <select name="is_active" id="is_active" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                        <option value="1">نشط</option>
                        <option value="0">غير نشط</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                        حفظ
                    </button>
                    <button type="button" onclick="resetForm()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>

        {{-- جدول الأدوية --}}
        <div class="flex-1 bg-white p-6 rounded-2xl shadow-md overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">قائمة الأدوية</h2>
                <a href="{{ route('medications.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition">
                    + إضافة دواء
                </a>
            </div>

            {{-- بحث --}}
            <form method="GET" class="mb-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="بحث باسم الدواء أو النوع..."
                           class="w-full rounded-xl border border-gray-300 pl-10 pr-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>

            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-right">#</th>
                        <th class="p-3 text-right">الاسم</th>
                        <th class="p-3 text-right">النوع</th>
                        <th class="p-3 text-right">الكمية</th>
                        <th class="p-3 text-right">السعر</th>
                        <th class="p-3 text-right">الانتهاء</th>
                        <th class="p-3 text-right">الحالة</th>
                        <th class="p-3 text-right">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($medications as $med)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3">{{ $med->id }}</td>
                            <td class="p-3 font-medium">{{ $med->name }}</td>
                            <td class="p-3">{{ $med->type ?? '-' }}</td>
                            <td class="p-3">
                                <span class="{{ $med->quantity <= $med->min_stock ? 'text-red-600 font-bold' : '' }}">
                                    {{ $med->quantity }}
                                </span>
                            </td>
                            <td class="p-3">{{ number_format($med->price, 2) }}</td>
                            <td class="p-3">
                                @if($med->expiry_date)
                                    <span class="{{ $med->isExpiringSoon ? 'text-red-600' : '' }}">
                                        {{ $med->expiry_date->format('Y-m-d') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-3">
                                @if($med->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">نشط</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">غير نشط</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <button type="button" onclick="editMedication({{ $med }})"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                        تعديل
                                    </button>
                                    <form action="{{ route('medications.destroy', $med) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('هل أنت متأكد؟')"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">لا توجد أدوية</td>
                        </tr>
                    @endforelse
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
    document.getElementById('medicationForm').action = '/medications/' + med.id;
    document.getElementById('form_method').value = 'PUT';
    document.getElementById('medication_id').value = med.id;
    document.getElementById('name').value = med.name;
    document.getElementById('type').value = med.type || '';
    document.getElementById('description').value = med.description || '';
    document.getElementById('quantity').value = med.quantity;
    document.getElementById('min_stock').value = med.min_stock;
    document.getElementById('price').value = med.price;
    document.getElementById('expiry_date').value = med.expiry_date || '';
    document.getElementById('is_active').value = med.is_active ? '1' : '0';

    // Change button text
    document.querySelector('#medicationForm button[type="submit"]').textContent = 'تحديث';
}

function resetForm() {
    document.getElementById('medicationForm').action = '{{ route("medications.store") }}';
    document.getElementById('form_method').value = 'POST';
    document.getElementById('medication_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('type').value = '';
    document.getElementById('description').value = '';
    document.getElementById('quantity').value = '';
    document.getElementById('min_stock').value = '';
    document.getElementById('price').value = '';
    document.getElementById('expiry_date').value = '';
    document.getElementById('is_active').value = '1';

    document.querySelector('#medicationForm button[type="submit"]').textContent = 'حفظ';
}
</script>
</x-app-layout>
