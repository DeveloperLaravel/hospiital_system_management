<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen" dir="rtl">
        <div class="max-w-4xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">إضافة وصفة طبية جديدة</h1>
                <a href="{{ route('prescriptions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    رجوع
                </a>
            </div>

            <form action="{{ route('prescriptions.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">السجل الطبي</label>
                        <select name="medical_record_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">اختر السجل الطبي</option>
                            @foreach($medicalRecords as $record)
                                <option value="{{ $record->id }}">
                                    #{{ $record->id }} - {{ $record->patient->name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('medical_record_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">الطبيب</label>
                        <select name="doctor_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">اختر الطبيب</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">ملاحظات</label>
                    <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3" placeholder="ملاحظات إضافية"></textarea>
                </div>

                <div class="border-t pt-4">
                    <h2 class="text-lg font-bold mb-4">الأدوية</h2>

                    <div id="items-container" class="space-y-4">
                        <div class="item-row grid grid-cols-1 md:grid-cols-6 gap-2 p-4 bg-gray-50 rounded">
                            <div class="md:col-span-2">
                                <label class="block text-xs mb-1">الدواء</label>
                                <select name="items[0][medication_id]" class="w-full border rounded px-2 py-1" required>
                                    <option value="">اختر الدواء</option>
                                    @foreach($medications as $medication)
                                        <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">الجرعة</label>
                                <input type="text" name="items[0][dosage]" class="w-full border rounded px-2 py-1" placeholder="جرعة" required>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">التكرار</label>
                                <input type="text" name="items[0][frequency]" class="w-full border rounded px-2 py-1" placeholder="مرات" required>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">المدة</label>
                                <input type="text" name="items[0][duration]" class="w-full border rounded px-2 py-1" placeholder="أيام" required>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">الكمية</label>
                                <input type="number" name="items[0][quantity]" class="w-full border rounded px-2 py-1" min="1" value="1" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addItem()" class="mt-3 text-blue-600 hover:text-blue-800 text-sm">
                        + إضافة دواء آخر
                    </button>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('prescriptions.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        إلغاء
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemCount = 1;

        function addItem() {
            const container = document.getElementById('items-container');
            const html = `
                <div class="item-row grid grid-cols-1 md:grid-cols-6 gap-2 p-4 bg-gray-50 rounded">
                    <div class="md:col-span-2">
                        <label class="block text-xs mb-1">الدواء</label>
                        <select name="items[${itemCount}][medication_id]" class="w-full border rounded px-2 py-1" required>
                            <option value="">اختر الدواء</option>
                            @foreach($medications as $medication)
                                <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">الجرعة</label>
                        <input type="text" name="items[${itemCount}][dosage]" class="w-full border rounded px-2 py-1" placeholder="جرعة" required>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">التكرار</label>
                        <input type="text" name="items[${itemCount}][frequency]" class="w-full border rounded px-2 py-1" placeholder="مرات" required>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">المدة</label>
                        <input type="text" name="items[${itemCount}][duration]" class="w-full border rounded px-2 py-1" placeholder="أيام" required>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">الكمية</label>
                        <input type="number" name="items[${itemCount}][quantity]" class="w-full border rounded px-2 py-1" min="1" value="1" required>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            itemCount++;
        }
    </script>
</x-app-layout>
