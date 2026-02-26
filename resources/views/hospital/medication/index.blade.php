<x-app-layout>
<div class="p-6 space-y-10" dir="rtl" lang="ar">

    {{-- ===================== --}}
    {{-- نموذج إضافة / تعديل --}}
    {{-- ===================== --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 max-w-4xl mx-auto">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            {{ isset($medication) ? 'تعديل دواء' : 'إضافة دواء جديد' }}
        </h2>

        <form method="POST"
              action="{{ isset($medication)
                ? route('medications.update',$medication)
                : route('medications.store') }}">
            @csrf
            @if(isset($medication)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-medium text-gray-700">اسم الدواء</label>
                    <input type="text" name="name"
                        value="{{ old('name',$medication->name ?? '') }}"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">نوع الدواء</label>
                    <select name="type"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
                        <option value="">اختر النوع</option>
                        <option value="tablet" {{ old('type',$medication->type ?? '')=='tablet'?'selected':'' }}>أقراص</option>
                        <option value="capsule" {{ old('type',$medication->type ?? '')=='capsule'?'selected':'' }}>كبسولات</option>
                        <option value="syrup" {{ old('type',$medication->type ?? '')=='syrup'?'selected':'' }}>شراب</option>
                        <option value="injection" {{ old('type',$medication->type ?? '')=='injection'?'selected':'' }}>حقن</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">الكمية</label>
                    <input type="number" name="quantity"
                        value="{{ old('quantity',$medication->quantity ?? 0) }}"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">السعر</label>
                    <input type="number" step="0.01" name="price"
                        value="{{ old('price',$medication->price ?? 0) }}"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date"
                        value="{{ old('expiry_date',$medication->expiry_date ?? '') }}"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-medium text-gray-700">الوصف</label>
                    <textarea name="description"
                        class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400"
                        rows="3">{{ old('description',$medication->description ?? '') }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex gap-4 justify-start flex-wrap">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                    حفظ
                </button>

                @if(isset($medication))
                    <a href="{{ route('medications.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                        إلغاء
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- ===================== --}}
    {{-- جدول عرض الأدوية --}}
    {{-- ===================== --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 max-w-6xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <form method="GET" class="w-full md:w-1/3">
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="بحث..."
                    class="border border-gray-300 w-full p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400">
            </form>

            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded shadow-md w-full md:w-auto text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border rounded-lg text-right min-w-[700px]">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-right">الاسم</th>
                        <th class="p-4">الكمية</th>
                        <th class="p-4">السعر</th>
                        <th class="p-4">النوع</th>
                        <th class="p-4">التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($medications as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">{{ $item->name }}</td>
                            <td class="p-4">{{ $item->quantity }}</td>
                            <td class="p-4">{{ number_format($item->price,2) }} ر.س</td>
                            <td class="p-4 capitalize">{{ $item->type }}</td>
                            <td class="p-4 flex gap-2 flex-wrap">

                                {{-- صلاحيات التعديل --}}
                                @can('medications-edit', $item)
                                    <a href="{{ route('medications.index', ['edit' => $item->id]) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded-lg shadow-sm transition">
                                       تعديل
                                    </a>
                                @endcan

                                {{-- صلاحيات الحذف --}}
                                @can('medications-delete', $item)
                                    <form method="POST"
                                          action="{{ route('medications.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('هل أنت متأكد من حذف هذا الدواء؟')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg shadow-sm transition">
                                            حذف
                                        </button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $medications->links() }}
        </div>

    </div>

</div>
</x-app-layout>
