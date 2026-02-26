<x-app-layout title="إدارة الأطباء">
    <main class="p-4 md:p-6 flex-1 overflow-auto" dir="rtl" lang="ar">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- جدول الأطباء -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-lg p-4 md:p-6 overflow-x-auto">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">قائمة الأطباء</h2>

                <table class="min-w-full text-right border-collapse shadow-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50">
                        <tr>
                            <th class="p-3 text-gray-700 font-medium border-b">الاسم</th>
                            <th class="p-3 text-gray-700 font-medium border-b">القسم</th>
                            <th class="p-3 text-gray-700 font-medium border-b">التخصص</th>
                            <th class="p-3 text-gray-700 font-medium border-b">الهاتف</th>
                            <th class="p-3 text-gray-700 font-medium border-b">رقم الترخيص</th>
                            <th class="p-3 text-gray-700 font-medium border-b">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $index => $doctor)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition-colors">
                                <td class="p-3 font-semibold">{{ $doctor->name }}</td>
                                <td class="p-3">{{ $doctor->department->name }}</td>
                                <td class="p-3">{{ $doctor->specialization }}</td>
                                <td class="p-3">{{ $doctor->phone ?? '-' }}</td>
                                <td class="p-3">{{ $doctor->license_number ?? '-' }}</td>
                                <td class="p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('doctors.index', ['edit' => $doctor->id]) }}"
                                       class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition">
                                        ✏ تعديل
                                    </a>
                                    @can('doctors-delete')
                                        <form method="POST" action="{{ route('doctors.destroy', $doctor) }}"
                                              onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الطبيب؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                                🗑 حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $doctors->links() }}
                </div>
            </div>

            <!-- الفورم -->
            <div class="bg-white shadow-lg rounded-lg p-4 md:p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    {{ isset($editDoctor) ? 'تعديل الطبيب' : 'إضافة طبيب' }}
                </h2>

                <form method="POST"
                      action="{{ isset($editDoctor) ? route('doctors.update', $editDoctor) : route('doctors.store') }}"
                      class="space-y-4">

                    @csrf
                    @if(isset($editDoctor))
                        @method('PUT')
                    @endif

                    <input name="name" placeholder="اسم الطبيب"
                           value="{{ old('name', $editDoctor->name ?? '') }}"
                           class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

                    <select name="department_id"
                            class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                        <option value="">اختر القسم</option>
                        @foreach($departments as $id => $name)
                            <option value="{{ $id }}"
                                {{ (old('department_id', $editDoctor->department_id ?? '') == $id) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>

                    <input name="specialization" placeholder="التخصص"
                           value="{{ old('specialization', $editDoctor->specialization ?? '') }}"
                           class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

                    <input name="phone" placeholder="الهاتف"
                           value="{{ old('phone', $editDoctor->phone ?? '') }}"
                           class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    <input name="license_number" placeholder="رقم الترخيص"
                           value="{{ old('license_number', $editDoctor->license_number ?? '') }}"
                           class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition">
                        {{ isset($editDoctor) ? 'تحديث' : 'حفظ' }}
                    </button>
                </form>
            </div>

        </div>
    </main>
</x-app-layout>
