<x-app-layout title="إدارة المرضى">
    <main class="p-6 flex-1 overflow-auto bg-gray-50 min-h-screen" dir="rtl">

        <div class="max-w-6xl mx-auto">

            <!-- إشعارات النجاح -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- قائمة المرضى -->
            <div class="bg-white shadow-xl rounded-2xl p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">قائمة المرضى</h2>

                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-blue-100">
                        <tr class="text-right">
                            <th class="border px-4 py-2">الاسم</th>
                            <th class="border px-4 py-2">اثبت هواية</th>
                            <th class="border px-4 py-2">العمر</th>
                            <th class="border px-4 py-2">الجنس</th>
                            <th class="border px-4 py-2">الهاتف</th>
                            <th class="border px-4 py-2">فصيلة الدم</th>
                            <th class="border px-4 py-2">العنوان</th>
                            <th class="border px-4 py-2">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr class="text-right hover:bg-gray-50 transition">
                            <td class="border px-4 py-2">{{ $patient->name }}</td>
                            <td class="border px-4 py-2">{{ $patient->national_id ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $patient->age ?? '-' }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $patient->gender ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $patient->phone ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $patient->blood_type ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $patient->address ?? '-' }}</td>
                            <td class="border px-4 py-2 flex gap-2 justify-end">
                                <!-- زر التعديل -->
                                <button onclick="openEditModal({{ $patient }})"
                                    class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg transition">تعديل</button>

                                <!-- زر الحذف -->
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">لا يوجد مرضى حتى الآن</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $patients->links() }}
                </div>
            </div>

            <!-- نموذج إضافة/تعديل المريض -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">إضافة / تعديل مريض</h2>

                <form id="patient-form" action="{{ route('patients.store') }}" method="POST" class="space-y-5 text-right">
                    @csrf
                    @method('POST')

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-1">الاسم</label>
                        <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" required>
                    </div>

                    <div>
                        <label for="national_id" class="block text-gray-700 font-semibold mb-1">الرقم الوطني</label>
                        <input type="text" name="national_id" id="national_id" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    </div>

                    <div>
                        <label for="age" class="block text-gray-700 font-semibold mb-1">العمر</label>
                        <input type="number" name="age" id="age" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    </div>

                    <div>
                        <label for="gender" class="block text-gray-700 font-semibold mb-1">الجنس</label>
                        <select name="gender" id="gender" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <option value="">اختر</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>

                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold mb-1">الهاتف</label>
                        <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    </div>

                    <div>
                        <label for="blood_type" class="block text-gray-700 font-semibold mb-1">فصيلة الدم</label>
                        <input type="text" name="blood_type" id="blood_type" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    </div>

                    <div>
                        <label for="address" class="block text-gray-700 font-semibold mb-1">العنوان</label>
                        <textarea name="address" id="address" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" rows="3"></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-6">
                        <button type="reset" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition shadow-sm">تفريغ الحقول</button>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition shadow-md">حفظ</button>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <!-- سكربت لتعبئة النموذج عند التعديل -->
    <script>
        function openEditModal(patient) {
            const form = document.getElementById('patient-form');
            form.action = `/patients/${patient.id}`;
            form.querySelector('[name="_method"]').value = 'PUT';
            form.querySelector('#name').value = patient.name;
            form.querySelector('#national_id').value = patient.national_id ?? '';
            form.querySelector('#age').value = patient.age ?? '';
            form.querySelector('#gender').value = patient.gender ?? '';
            form.querySelector('#phone').value = patient.phone ?? '';
            form.querySelector('#blood_type').value = patient.blood_type ?? '';
            form.querySelector('#address').value = patient.address ?? '';
            window.scrollTo({ top: form.offsetTop - 20, behavior: 'smooth' });
        }
    </script>

</x-app-layout>
